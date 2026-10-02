# D15-01B Implementation Report

## 1. Scope
Implementasi performa pada katalog publik dan *caching*, sesuai dengan hasil audit D15-01A. Berfokus untuk menghilangkan *bottleneck query* pada pengambilan filter `brands` (`whereHas`) dan membungkus hasil agregasi `$categories` serta `$brands` dalam Application Cache untuk meminimalkan beban koneksi database di halaman dengan trafik tinggi (mitigasi untuk *max_user_connections*).

## 2. D15-01A Evidence
- **Query 6 (`whereHas`)**: Pada hasil revalidation LOCAL, query `EXISTS` menunjukkan *table scan* pada tabel `products`. Pola ini berpotensi menjadi bottleneck ketika volume data meningkat.
- **Cache Mismatch**: Halaman dengan beban pengunjung terbanyak terus memanggil query DB kompleks di `ProductController@index` meskipun data kategorinya bersifat statis (jarang berubah).
- **Index Standalone**: `is_active` telah dibuktikan di D15-01A sebagai tidak diperlukan dan tidak ditambahkan.
- **max_user_connections**: Merupakan faktor penyumbang (*contributing factor*) dari *cache miss*, dan mitigasi aplikatif (*caching*) adalah strategi terkuat.

## 3. Files Changed
- `app/Http/Controllers/ProductController.php` (Penambahan fitur caching & refaktor query).
- `app/Models/Traits/ClearsCatalogCache.php` (Trait Observer baru untuk Invalidation).
- `app/Models/Product.php` (Penerapan Trait).
- `app/Models/Category.php` (Penerapan Trait).
- `app/Models/Brand.php` (Penerapan Trait).
- `tests/Feature/CatalogCacheTest.php` (File Test Baru).
- `docs/D15_01B_IMPLEMENTATION_REPORT.md` (Dokumentasi ini).

## 4. Query Optimization
Mengubah logika *filtering* pada brand dari `whereHas('products')` menjadi filter relasi di level PHP setelah *count* (*in-memory filtering*).
**Before:**
`Brand::whereHas('products', fn($q) => $q->active())->withCount(...)`
(Cost query MySQL: ~10.48ms)

**After:**
`Brand::withCount(...)->get()->filter(fn($b) => $b->products_count > 0)->values()`
(Cost query MySQL: ~0.55ms)
Perubahan menggunakan `filter()` PHP ini jauh lebih cepat (O(N) *in-memory* di mana N jumlah brand <100) serta ramah secara *testing* terhadap SQLite yang melarang `HAVING` tanpa grup pada versi lamanya.

## 5. Caching Strategy
Menggunakan fungsi `Cache::remember` dengan durasi 3600 detik (1 jam) untuk menangkap data `$categories` dan `$brands` beserta _count_-nya pada rute `/produk` dan `/produk/{category}`. Cache mem-bypass *query* agregasi sepenuhnya saat HIT.

## 6. Cache Key Strategy
Key dibedakan berdasarkan konteks:
- `catalog:categories` (Global category list with total product count).
- `catalog:brands` (Global brand list with total product count).
- `catalog:brands:category:{id}` (Brand list with count of products specifically inside the category ID).

## 7. Cache Invalidation
Aplikasi Cache dirancang statis namun reaktif (*event-driven*).
Ketika ada Event `saved` atau `deleted` pada model `Product`, `Category`, atau `Brand` (melalui Trait `ClearsCatalogCache`):
- `catalog:categories` dan `catalog:brands` dihapus secara eksplisit.
- Cache *category-specific brands* (`catalog:brands:category:*`) dihapus menggunakan ID category pada produk, atau seluruh ID kategori yang terdaftar (jika modifikasi terjadi di level `Brand` atau `Category`).

## 8. Tests
`tests/Feature/CatalogCacheTest.php` mencakup 5 Skenario Uji:
1. `catalog fetches and caches categories and brands` (Uji HIT dan pengurangan drastis Query log).
2. `catalog category filter caches brands separately` (Uji isolasi antar kategori).
3. `cache is invalidated on product mutation` (Uji pembaharuan Cache berkat Trait `ClearsCatalogCache`).
4. `cache is invalidated on category mutation`.
5. `cache is invalidated on brand mutation`.

Seluruh `Test Suite` Lynvo (87 tests / 263 assertions) juga berstatus PASS.

## 9. Performance Before/After
Benchmark berikut merupakan hasil pengukuran pada environment LOCAL dan bukan pengukuran production.
Diukur melalui kueri simulasi `index()`:
| Metric | Before | After (Cache Hit) | Result |
|--------|--------|-------|--------|
| Query Count | 6 queries / request | **2 queries** / request (hanya count dan offset pagination) | Pengurangan -66% Query Beban Tinggi |
| Runtime main query | ~10.48 ms (`whereHas`) | **0 ms** (Cached), jika Cache Miss ~0.55ms (`withCount` only) | Mengurangi I/O Eksekusi |
| DB Connection Usage| Tersita per load sub-query | Cepat dilepaskan | Expected mitigation reduction |

## 10. Regression Verification
- Produk, Filter, dan Pencarian berfungsi.
- Data Catalog dan Detail Product tidak rusak.
- SQLite Compatibility Testing aman.
- `php artisan test` (100% PASS).
- `git diff --check` (No trailing whitespaces/EOF issues).

## 11. Limitations
Simulasi ini menggunakan file local driver Laravel. Jika production menggunakan Redis sebagai cache driver, strategi ini diharapkan mengurangi frekuensi query agregasi katalog saat cache HIT dan dengan demikian dapat membantu mengurangi beban database. Dampaknya terhadap max_user_connections belum dapat dipastikan tanpa metrik production.

## 12. Final Status
Implementasi dinyatakan aman dan dapat dipersiapkan untuk proses *review* SA sebelum `commit`. Tidak ada migrasi tambahan maupun dependensi baru. Caching telah diproteksi dengan Invalidasi dan tidak mengubah *Business Rules*.
