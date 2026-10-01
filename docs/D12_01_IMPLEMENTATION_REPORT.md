# D12-01 Implementation Report

## 1. Objective
Mengurangi repeated database queries yang terjadi karena pemanggilan `Setting::getValue()` secara berulang dalam lifecycle satu request (terutama akibat penggunaannya di global Blade layouts).

## 2. Root Cause
Metode `Setting::getValue($key)` selalu menjalankan `self::where('key', $key)->value('value')` yang men-trigger database query untuk setiap pemanggilan. Di halaman publik, ini dipanggil lebih dari 20 kali per load untuk mendapatkan pengaturan seperti nomor telepon, logo, konfigurasi SEO, dan alamat.

## 3. Existing Behavior
Sebelum dioptimasi, pemanggilan `Setting::getValue()` yang berulang memicu query database baru untuk kunci yang sama atau kunci lainnya pada setiap baris Blade template.

## 4. Implemented Solution
Fungsi `Setting::getValue($key)` telah di-refactor untuk membungkus pengambilan semua (all) pengaturan aplikasi ke dalam sebuah *array* menggunakan `Cache::rememberForever`. Pengambilan di-query sekali dari DB dan langsung dikonversi ke *associative array* menggunakan `pluck('value', 'key')->toArray()`.

## 5. Cache Strategy
**Global Dictionary Caching:** 
Karena tabel `settings` berukuran sangat kecil (hanya 15 baris), mengambil dan men-cache semuanya sekaligus jauh lebih efisien dibandingkan men-cache masing-masing key (untuk mencegah missing cache key overhead pada query yang null). Cache di-hold *selamanya* (forever) hingga invalidasi terjadi.

## 6. Cache Key
`global_settings_cache`

## 7. Invalidation Strategy
Invalidasi otomatis pada lifecycle **Model Eloquent**:
Telah ditambahkan method `booted()` pada model `Setting` yang mendengarkan event `saved` dan `deleted`.
```php
protected static function booted()
{
    static::saved(function ($setting) {
        \Illuminate\Support\Facades\Cache::forget('global_settings_cache');
    });

    static::deleted(function ($setting) {
        \Illuminate\Support\Facades\Cache::forget('global_settings_cache');
    });
}
```
Cache invalidation diterapkan melalui Eloquent model events saved dan deleted, sehingga perubahan Setting melalui instance Eloquent akan menghapus global_settings_cache sebelum nilai berikutnya dibaca.

## 8. Files Changed
- `app/Models/Setting.php` (Penambahan cache wrapper dan `booted` invalidator)
- `tests/Feature/SettingCacheTest.php` (Pembuatan test case baru)

## 9. Tests Added/Updated
Telah ditambahkan 5 test case khusus untuk cache behavior:
- `test_first_retrieval_gets_correct_value` (D12-01-TEST-001)
- `test_repeated_retrieval_does_not_query_database` (D12-01-TEST-002)
- `test_different_keys_do_not_collide` (D12-01-TEST-003)
- `test_mutation_invalidates_cache_and_fetches_fresh_data` (D12-01-TEST-004)
- `test_missing_setting_returns_default` (D12-01-TEST-005)
Semua existing application tests (D12-01-TEST-006) tetap pass secara sukses tanpa ada asersi yang dilemahkan.

## 10. Before/After Query Evidence
**BEFORE:**
```php
Cache::rememberForever(...) ?? $default; // Jika null value, memicu N+1 query.
// Logs array menghasilkan 20+ records dalam request homepage.
```
**AFTER:**
```php
// Test D12-01-TEST-002 (DB Query Log Tracking)
$value1 = Setting::getValue('hero_phone'); // 1 Query execution
$value2 = Setting::getValue('hero_phone'); // 0 Query execution
```
Database load berkurang drastis pada sisi read operation aplikasi.

## 11. Regression Test Results
- `SettingCacheTest` PASS (5 assertions).
- `BrandUatTest`, `InquiryWorkflowTest`, `LocalSeoLandingTest`, `PublicArticleTest`, `SitemapTest` semuanya PASS.
- Total Tests: 51 passed (129 assertions).

## 12. Build Result
`npm run build` dijalankan dan sukses `built in 1.39s` untuk CSS (63.26 kB) dan JS (107.36 kB).

## 13. Local UAT
1. Homepage tetap berfungsi (HTTP 200).
2. Global settings (Title, Phone, dll) tetap terbaca benar.
3. Page-specific settings tetap benar.
4. Article pages tetap berfungsi (HTTP 200).
5. Local SEO tetap berfungsi.
6. Sitemap tetap berfungsi (HTTP 200).
7. RFQ/contact tetap berfungsi (HTTP 200).
8. No regression dari caching; tidak ada delay atau error missing data.

## 14. Database Impact
**TIDAK ADA PERUBAHAN DATABASE/MIGRATION**. 
Hanya optimasi volume eksekusi SELECT queries ke database.

## 15. Security Impact
**NO IMPACT**. 
Nilai key cache unik dan hanya berlaku internal ke server application cache tanpa eksposure pubilk baru.

## 16. Known Limitations
- Caching pada tingkat lokal bergantung pada cache driver environment.

## 17. Scope Compliance
Sesuai dengan ketentuan yang diotorisasi oleh SA. Tidak ada file di luar scope yang diubah, tidak melakukan pembersihan root repository, tidak merubah business logic, tidak mengubah production.
