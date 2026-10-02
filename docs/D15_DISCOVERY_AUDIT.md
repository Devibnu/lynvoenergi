# D15 — DISCOVERY AUDIT REPORT
**Project:** Lynvo Energi
**Date:** 2026-10-02
**Environment:** Production (`origin/main`)

---

## 1. SECURITY (SEC)

### SEC-02: Missing Rate Limiting pada `POST /inquiry`
- **Severity:** HIGH
- **Location:** `routes/web.php` & `app/Http/Controllers/PageController.php@storeInquiry`
- **Evidence:** Route `POST /inquiry` menangani form submission (B2B, kontak, layanan) dan mengirimkan notifikasi. Tidak ada middleware `throttle` (seperti `throttle:6,1` atau sejenisnya) yang dipasang pada route group `web` di `Kernel.php` atau pada spesifik route `/inquiry`.
- **Impact:** Rentan terhadap serangan spam / form bot yang dapat membanjiri database dengan ratusan request per menit, serta memicu pengiriman pesan error terus-menerus.

---

## 2. DATABASE & PERFORMANCE (DB & PRF)

### PRF-02: Missing Query Caching pada Public Catalog (Root Cause `max_user_connections`)
- **Severity:** CRITICAL
- **Location:** `app/Http/Controllers/ProductController.php` (method `index` & `category`)
- **Evidence:**
  Setiap kali pengunjung membuka halaman katalog (`/products` atau `/products/{category}`), aplikasi mengeksekusi:
  ```php
  $categories = Category::withCount(['products' => fn($q) => $q->active()])->get();
  $brands = Brand::whereHas('products', fn($q) => $q->active())
                 ->withCount(['products' => fn($q) => $q->active()])->get();
  ```
  Kueri ini tidak di-cache sama sekali. Pada traffic tinggi (misal: campaign Iklan SEO), eksekusi kueri agregasi (`COUNT` dan `EXISTS`) yang dilakukan secara berulang-ulang untuk setiap session/user menyebabkan thread pool MySQL habis.
- **Impact:** Ini adalah penyebab utama dari log error **`SQLSTATE[HY000] [1203] 'max_user_connections' active connections`** yang diamati di production.

### DB-01: Missing Index pada Kolom Filter (Boolean)
- **Severity:** HIGH (Validated from D14)
- **Location:** `database/migrations/2026_09_15_000004_create_products_table.php` (dan migrasi lain)
- **Evidence:** Kolom `is_active` digunakan sebagai `scopeActive` dan filter utama pada setiap kueri public, termasuk di dalam sub-kueri agregasi `withCount` (PRF-02). Namun, tidak ada deklarasi `$table->index('is_active')`.
- **Impact:** Memperparah masalah `PRF-02`. Database terpaksa melakukan table scan (atau index fallback) saat menghitung produk aktif, memperlambat response time secara signifikan saat tabel produk sudah membesar.

### PRF-01: Laravel Strict Mode / `preventLazyLoading` Non-Aktif
- **Severity:** MEDIUM (Validated from D14)
- **Location:** `app/Providers/AppServiceProvider.php`
- **Evidence:** Method `boot()` tidak mendeklarasikan `Model::preventLazyLoading(!app()->isProduction())`.
- **Impact:** Potensi kebocoran memori atau N+1 query jika ada modifikasi baru di masa depan (silent degradation).

---

## 3. MAINTAINABILITY & CLEAN CODE (MNT)

### MNT-01: Dead Code (Soft UI Template Leftovers)
- **Severity:** LOW / INFO
- **Location:**
  - Controllers: `InfoUserController`, `RegisterController`, `ResetController`, `SessionsController`, `ChangePasswordController`
  - Views: `resources/views/billing.blade.php`, `profile.blade.php`, `rtl.blade.php`, `virtual-reality.blade.php`, `tables.blade.php`
- **Evidence:** File-file tersebut tersisa dari template bawaan Soft UI Dashboard, namun tidak di-register pada `routes/web.php` dan tidak pernah digunakan oleh aplikasi.
- **Impact:** Menambah ukuran codebase dan dapat menimbulkan kebingungan bagi developer (technical debt).

---

## KESIMPULAN & REKOMENDASI SUBPHASE (D15.x)

1. **[CRITICAL] D15-01 (Catalog Performance & DB Hardening):**
   - Tambahkan index pada `is_active`.
   - Implementasikan Laravel Cache (`Cache::remember`) untuk data filter sidebar (`$categories` & `$brands`) di `ProductController` agar mengurai beban DB dan menstabilkan production dari error `max_user_connections`.
2. **[HIGH] D15-02 (Form Abuse Prevention):**
   - Tambahkan `Route::middleware('throttle:5,1')` atau sejenisnya pada endpoint `POST /inquiry`.
3. **[MEDIUM] D15-03 (Strict Mode):**
   - Aktifkan `preventLazyLoading` di `AppServiceProvider` khusus untuk environment non-production.
4. **[LOW] D15-04 (Cleanup):**
   - Hapus dead code controller dan views template bawaan.
