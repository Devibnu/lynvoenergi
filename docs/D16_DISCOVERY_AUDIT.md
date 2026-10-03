# D16 Discovery Audit

## A. Baseline
- **Branch**: main
- **Commit**: `2abfb87b820694b044174f59e392a1cac3d27f5e`
- **Status**: Read-only discovery phase. No code modifications, migrations, or deployments were performed.

## B. Audit Methodology
Audit dilakukan secara statis dengan menganalisa source code dan struktur database melalui repository read-only.
Tooling yang digunakan:
- `grep` search untuk pattern finding (N+1 queries, missing cache, controller setup).
- `php artisan model:show` untuk mengecek schema database dan foreign key indexing.
- Code review pada Controllers, Middleware, Blade Views, dan Database Migrations.

## C. Findings

### 1. Missing Slug Uniqueness Validation in Admin Controllers
- **ID**: `D16-FINDING-01`
- **Severity**: HIGH
- **Area**: Laravel Architecture / Admin Panel
- **File/path**: 
  - `app/Http/Controllers/Admin/ProductController.php`
  - `app/Http/Controllers/Admin/CategoryController.php`
  - `app/Http/Controllers/Admin/ApplicationController.php`
- **Evidence**: Controller tidak melakukan validasi unik pada field `name`, namun melakukan auto-generate `slug` dari `name` menggunakan `Str::slug()`. Sementara itu, database migration memiliki modifier `unique` pada kolom `slug`.
- **Impact**: Jika admin menginputkan produk/kategori dengan nama yang sama, generator akan membuat slug yang sama. Hal ini mengakibatkan `QueryException` (Integrity constraint violation HTTP 500) alih-alih menampilkan pesan error validasi yang ramah (HTTP 422).
- **Verification**: Terverifikasi pada source code Controller (hanya `BrandController` dan `ProjectController` yang sudah mengimplementasikan unique/exists check).
- **Recommendation**: Tambahkan validasi `unique:products,name` di Request Validation atau handle unique check pada `slug` sebelum menyimpannya ke database.
- **Confidence**: CONFIRMED

### 2. Missing Database Indexes for Query Filters
- **ID**: `D16-FINDING-02`
- **Severity**: MEDIUM
- **Area**: Database Integrity / Performance
- **File/path**: `database/migrations/2026_09_15_000004_create_products_table.php` (dan migrasi tabel terkait lainnya)
- **Evidence**: Eksekusi `php artisan model:show App\Models\Product` menunjukkan tidak adanya indeks (`index`) pada kolom yang sering digunakan untuk filtering, seperti `category_id`, `brand_id`, `is_active`, `is_popular_retail`. 
- **Impact**: Setiap query ke frontend publik yang menggunakan klausa `->where('is_active', 1)->where('is_popular_retail', 1)` akan melakukan *Full Table Scan* pada RDBMS, sehingga merugikan skalabilitas aplikasi dan responsibilitas halaman.
- **Verification**: Terverifikasi dari blueprint database (`products`, `articles`).
- **Recommendation**: Buat file migration baru untuk menambahkan `index()` pada kolom-kolom relasi (`*_id`) dan boolean/status flags.
- **Confidence**: CONFIRMED

### 3. Missing Query Caching on Homepage (Heavy Controller)
- **ID**: `D16-FINDING-03`
- **Severity**: MEDIUM
- **Area**: Performance
- **File/path**: `app/Http/Controllers/HomeController.php`
- **Evidence**: `HomeController@index` mengeksekusi hingga 7 query model terpisah (`Category`, `Application`, `Brand`, `Product`, `Project`, `CoverageArea`, `Article`) setiap kali homepage di-load. Tidak ada implementasi `Cache::remember()` di level Controller.
- **Impact**: Trafik publik di homepage dapat membebani database dan meningkatkan *Time To First Byte* (TTFB), khususnya di peak-traffic.
- **Verification**: Terverifikasi. Controller mengeksekusi `get()` pada berbagai entitas secara berurutan tanpa wrapper `Cache::remember()`.
- **Recommendation**: Terapkan implementasi caching (seperti yang dilakukan pada `Settings` dan `Products Catalog`) menggunakan block `Cache::remember()` untuk data yang jarang berubah (brands, popular products, dll).
- **Confidence**: CONFIRMED

### 4. Missing Eager Loading pada Relasi 'Brand' di Local SEO
- **ID**: `D16-FINDING-04`
- **Severity**: LOW
- **Area**: Performance / Query
- **File/path**: 
  - `app/Http/Controllers/LocalSeoController.php`
  - `resources/views/pages/local-landing.blade.php`
  - `resources/views/pages/service-hub.blade.php`
- **Evidence**: `LocalSeoController` (pada fungsi `showLocalLanding` dan `serviceHub`) melakukan fetch `$popularProducts = Product::with(['category'])->...`. Controller tidak meng-include `brand`. Di Blade views, terdapat percobaan bypass pemanggilan menggunakan `$prod->getRelationValue('brand')?->name`. 
- **Impact**: Jika data brand tidak dieager load, atribut brand ter-skip atau bisa memicu N+1 saat lazy loading tidak di-prevent.
- **Verification**: Terverifikasi pada code Controller & Views.
- **Recommendation**: Tambahkan `'brand'` ke array `$query->with(['category', 'brand'])` pada Controller.
- **Confidence**: CONFIRMED

### 5. Missing Authentication Middleware on Logout Route
- **ID**: `D16-FINDING-05`
- **Severity**: LOW
- **Area**: Security
- **File/path**: `routes/web.php`
- **Evidence**: `Route::post('/logout', [...])` tidak memiliki modifier `->middleware('auth')`.
- **Impact**: Unauthenticated guests dapat memanggil endpoint `/logout`. Walaupun dilindungi token CSRF dan secara bawaan Laravel akan mengabaikannya, *best practice* adalah meng-auth proteksi endpoint logout untuk menjaga semantics dan route mapping.
- **Verification**: Route `logout` berada di luar blok middleware `auth`.
- **Recommendation**: Tambahkan `->middleware('auth')` pada deklarasi route `logout`.
- **Confidence**: CONFIRMED

## D. Regression Check
- Legacy Soft UI code deletion (D15-04) tidak memunculkan dead links di `routes/web.php`.
- Frontend views (`home`, `products.index`, local landing pages) dapat mem-parse `Product::active()` dan struktur UI Vite dengan benar.
- *Status:* **NO REGRESSION FOUND** dalam static audit.

## E. Not Confirmed / Not Testable
- Bottleneck spesifik pada production environment (I/O, network) belum dites ulang tanpa akses APM/Metrics, sehingga tidak diklaim dalam dokumen ini.

## F. Deferred Items
- Modernisasi Admin UI (UX Debt): Seperti yang disetujui pada iterasi sebelumnya, hutang terkait Admin (terms, UX pattern) ditangguhkan dari ruang lingkup saat ini.

## G. Recommended D16 Phase Order
Berdasarkan prioritas stabilitas dan UX, urutan tindakan (Implementation Roadmap) D16 yang direkomendasikan adalah:

1. **D16-01 (Architecture Fix)**: Mengatasi `D16-FINDING-01` dengan menambal missing validation constraint `unique` pada nama produk/kategori. *(Critical for Stability)*
2. **D16-02 (Database Optimization)**: Mengatasi `D16-FINDING-02` (Indexes creation).
3. **D16-03 (Performance Enhancement)**: Mengatasi `D16-FINDING-03` & `D16-FINDING-04` dengan optimasi Controller level Cache & Eager load fix.
4. **D16-04 (Security Polish)**: Mengatasi `D16-FINDING-05`.

## H. Conclusion
Aplikasi Lynvo Energi secara umum stabil dengan dependencies frontend (Vite/Tailwind) yang bersih berkat cleanup pada fase D15. Target-target D16 lebih berfokus pada **Pencegahan Error Skala Admin** (Missing Validations), dan **Optimasi Database** (Indexes, Query Caching). Tidak ada masalah keamanan berat (SQL Injection / XSS) yang dikonfirmasi pada public-facing code. 
