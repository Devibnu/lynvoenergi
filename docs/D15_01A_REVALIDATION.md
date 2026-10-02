# D15-01A Revalidation

## 1. Executive Summary
Audit ulang ini (revalidation) dilakukan untuk menguji klaim dari D15 yang menyebutkan bahwa *query caching* yang absen (PRF-02) pada `ProductController@index` adalah **root cause** dari masalah `max_user_connections`, dan bahwa indeks mandiri pada `is_active` (DB-01) sangat dibutuhkan (HIGH severity).
Hasil revalidasi membuktikan bahwa:
1. Tidak ditemukan adanya N+1 query loop di dalam `index()`.
2. Indeks tunggal pada `is_active` sebenarnya **NOT NEEDED** karena selektivitasnya rendah, dan *query planner* sebagian besar sudah mampu menggunakan *foreign-key index* yang ada.
3. *Root cause* untuk `max_user_connections` **UNPROVEN** secara pasti karena tidak adanya *historical metrics* / APM, meski *caching* tetap sangat disarankan sebagai optimasi dan mitigasi yang efektif.

## 2. Previous D14 Evidence
Pada D14-03, ditemukan bahwa eksekusi query seperti `SELECT * FROM products WHERE category_id = 1 AND is_active = 1` sudah dilayani secara efisien oleh MySQL menggunakan indeks bawaan (built-in foreign key index): `products_category_id_foreign`. Hal ini sempat menggugurkan perlunya indeks baru pada tipe data boolean. Namun D15 kembali menaikkan isu DB-01 untuk semua tabel yang memiliki `is_active`.

## 3. ProductController@index Audit
Fokus pada endpoint katalog utama `ProductController@index`.
```php
$query = Product::active()->with(['category', 'brand']);
// ... (Filter name, category, brand, capacity) ...
$products = $query->paginate(12)->withQueryString();

$categories = Category::withCount(['products' => fn($q) => $q->active()])->get();

$brands = Brand::whereHas('products', fn($q) => $q->active())
    ->withCount(['products' => fn($q) => $q->active()])
    ->get();
```
Controller tidak melakukan modifikasi N+1 di dalam loop. Namun, sub-query kompleks ditambahkan ke agregasi kategori dan brand pada setiap request katalog tanpa ada mekanisme *caching* sama sekali.

## 4. Query Inventory
Saat `ProductController@index` dieksekusi tanpa filter, terdapat **6 Query Database** yang dijalankan:
1. `select count(*) from products where is_active = 1` (Pagination count)
2. `select * from products where is_active = 1 limit 12` (Pagination records)
3. `select * from categories where id in (...)` (Eager load relasi produk)
4. `select * from brands where id in (...)` (Eager load relasi produk)
5. Agregasi `Category::withCount` (Subquery menghitung produk aktif per kategori)
6. Agregasi `Brand::whereHas...withCount` (EXISTS subquery dan COUNT subquery untuk produk aktif per brand)

Tidak ditemukan kueri yang berulang/duplikat (N+1) per *row*. Main expensive query secara teoritis ada pada *Query 6* (`whereHas`).

## 5. Runtime Query Evidence
Pengujian lokal menggunakan `DB::getQueryLog()` menunjukkan total eksekusi sekitar ~12ms. Kueri ke-6 memakan porsi tertinggi (sekitar ~1.86ms s/d 3ms) di mana MySQL menggunakan strategi *Materialization* (menyiapkan sub-query ke temporary table lalu di-join). Angka ini sangat kecil karena database lokal hanya memiliki **6 produk**, namun bisa berlipat ganda secara eksponensial di tabel yang besar.

## 6. withCount Analysis
**Code:** `Category::withCount(['products' => fn($q) => $q->active()])->get();`
**SQL:** `select categories.*, (select count(*) from products where categories.id = products.category_id and is_active = 1) as products_count from categories`
- **Relationship:** `HasMany` (dari `Category` ke `Product`)
- **Existing Index:** `products_category_id_foreign`
- **EXPLAIN:** Query planner MySQL menunjukkan subquery **menggunakan** index `products_category_id_foreign`. Indeks terbukti cukup dan ini tidak menjadi bottleneck. (`Index lookup on products using products_category_id_foreign`).

## 7. whereHas Analysis
**Code:** `Brand::whereHas('products', fn($q) => $q->active())`
**SQL:** `where exists (select * from products where brands.id = products.brand_id and is_active = 1)`
- **EXPLAIN:** MySQL menggunakan *Nested loop inner join* dengan tabel materialisasi dari `Table scan on products`.
- **Apakah bottleneck?** Ya, sangat potensial. Saat jumlah produk sangat banyak, subquery `EXISTS` memicu *Full Table Scan* pada `products` karena index yang ada tidak secara sempurna mencakup seluruh kolom kondisi (`brand_id` dan `is_active`) secara sekuensial.

## 8. Existing Index Inventory
Tabel `products` sudah memiliki:
- `products_category_id_foreign`
- `products_brand_id_foreign` (dari migrasi sebelumnya)
Tidak ada *Composite Index* seperti `(brand_id, is_active)` atau `(category_id, is_active)`.

## 9. is_active Validation
Kondisi `is_active = 1` terus menerus digunakan (melalui `scopeActive`).
Hasil pengujian:
A. `SELECT * FROM products WHERE is_active = 1` -> Menggunakan `Table scan` (full scan).
B. `SELECT * FROM products WHERE category_id = 1 AND is_active = 1` -> Tetap menggunakan `Index lookup` (berbasis `category_id`).
C. `EXISTS (SELECT * FROM products WHERE brand_id = X AND is_active = 1)` -> Menggunakan `Table scan`.

## 10. EXPLAIN Evidence
- `EXPLAIN select count(*) from products where is_active=1`
  `-> Table scan on products`
- `EXPLAIN select categories.*, (select count(*)...) ...`
  `-> Index lookup on products using products_category_id_foreign`
- `EXPLAIN select brands.* ... where exists (...)`
  `-> Table scan on <subquery3>` `-> Table scan on products`

## 11. Selectivity Evidence
Jumlah produk pada _dummy database_ saat ini:
- Total: 6
- Active: 6 (100%)
- Inactive: 0 (0%)
Pada umumnya, `is_active = 1` memiliki selektivitas yang sangat rendah (mayoritas data aktif). Oleh karena itu, indeks mandiri `INDEX(is_active)` adalah **NOT NEEDED**. MySQL *query planner* akan otomatis mengabaikannya dan lebih memilih *table scan* karena *cost* mengambil baris dari indeks lebih besar daripada *scan* keseluruhan untuk 90% kecocokan.

## 12. Caching Suitability
Aplikasi katalog di `ProductController` **sangat cocok** untuk di-cache (Application Caching).
- **Stabilitas:** Daftar kategori dan daftar merek jarang berubah dalam hitungan menit/jam.
- **Toleransi:** Terdapat toleransi *stale data* yang cukup tinggi (misal 1 jam) untuk kalkulasi agregasi `products_count`.
- **Strategi:** Dapat dilakukan caching pada query builder untuk variabel `$categories` dan `$brands`. Invalidation *key* bisa diterapkan saat ada _Event_ pembuatan/update produk.

## 13. max_user_connections Analysis
Error `max_user_connections` terjadi pada 2026-09-25. Bukti yang ada (tidak adanya log APM, *slow query log*, atau *processlist metrics*) tidak cukup untuk secara definitif menyebut `ProductController@index` sebagai **Root Cause**.
Faktor kontribusinya jelas (*Missing Cache* pada *heavy subquery* di *high traffic page*), tapi root cause pastinya dinyatakan: **ROOT CAUSE UNPROVEN**.

## 14. Finding Verdict
| Finding | Evidence | Existing Protection | Verdict |
|---------|----------|---------------------|---------|
| PRF-02 (Query Caching) | Controller melakukan 6 query/request, `whereHas` tanpa cache. | Tidak ada | **PARTIALLY CONFIRMED** (Masalah benar ada, tapi root-cause max_user_connections tidak terbukti). |
| DB-01 (`is_active` index)| `is_active` selectivity rendah (majority=1). EXPLAIN membuktikan table scan digunakan karena data kecil/selectivity rendah. | Foreign Key Indexes | **NOT CONFIRMED** (Standalone index tidak berguna. Composite index `(brand_id, is_active)` masih mungkin, tapi data saat ini terlalu minim). |

## 15. Recommended Implementation Scope
### Caching Decision
**A. Implement**
(Direkomendasikan untuk menerapkan `Cache::remember` untuk `$categories` dan `$brands` guna mengoptimasi dan mitigasi risiko DB exhaustion).

### Index Decision
**B. Existing index sufficient (untuk standalone `is_active`) / C. Further evidence required (untuk composite index).**
(Jangan menambahkan `INDEX(is_active)`. *Foreign-key index* yang sudah ada cukup memadai saat ini).

### max_user_connections
**D. Root cause unproven**
(Namun `ProductController@index` adalah **Contributing Factor Proven** akibat *cache miss*).

## 16. Limitations
Revalidasi dilakukan di *local environment* dengan dataset seadanya (6 produk). Tanpa *dump* struktur dan trafik *production* yang riil, dampak dari *table scan* pada *Materialized EXISTS query* tidak dapat disimulasikan secara komprehensif. Menganalisis *slow query log* dari server MySQL produksi adalah satu-satunya jalan pembuktian konkret.
