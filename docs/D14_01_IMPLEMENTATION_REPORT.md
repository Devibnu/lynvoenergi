# D14-01 IMPLEMENTATION REPORT: LOGIN BRUTE-FORCE PROTECTION

## Finding
**SEC-01** — Missing Rate Limiting / Brute Force Protection pada endpoint POST `/login`.

## Root Cause
Endpoint `/login` menggunakan `LoginController` kustom yang tidak mewarisi sifat `ThrottlesLogins` bawaan Laravel dan tidak mendaftarkan middleware `throttle` pada `routes/web.php`. Akibatnya tidak ada mekanisme rate limiting dari aplikasi.

## Implementation
Menambahkan pemanggilan facade `Illuminate\Support\Facades\RateLimiter` di dalam metode `login` pada `app/Http/Controllers/Auth/LoginController.php`. Implementasi ini terintegrasi langsung di layer controller sebelum `Auth::attempt` dijalankan, mempertahankan seluruh logika validasi dan _flow_ redirect.

## Rate Limit Configuration
- **Mekanisme Throttle**: Kombinasi kredensial (email) dan IP address penelepon (`$request->input('email') . '|' . $request->ip()`), diubah ke bentuk *lowercase*.
- **Max Attempts**: 5 kali percobaan yang gagal berturut-turut.
- **Window (Lockout)**: 60 detik (1 menit).
- **Behavior**: Menghitung *hits* jika login gagal dan me-reset (_clear_) perhitungan jika login berhasil. Jika *limit* tercapai, akan mengembalikan respons form dengan string error (dalam Bahasa Indonesia) berisi waktu tunggu yang tersisa, tanpa membocorkan validitas _credential_.

## Files Changed
1. `app/Http/Controllers/Auth/LoginController.php` (Penambahan integrasi RateLimiter)
2. `database/factories/UserFactory.php` (Menghapus *property dummy* `email_verified_at` yang tidak digunakan di tabel)
3. `tests/Feature/LoginBruteForceTest.php` (Pembuatan test class baru)

## Tests
- **D14-01 Focused Test**: `Tests\Feature\LoginBruteForceTest` berhasil (5 passed).
- **Full Test Suite**: Keseluruhan 81 tests dengan 242 assertions (termasuk fitur _inquiry_, _sitemap_, dll) *PASS*. Tidak ada dampak negatif ke fungsionalitas lain.
- **git diff --check**: *Clean*.

## Security Considerations
Mekanisme `email|ip` mempersulit *attacker* untuk mem-bypass rate limiter karena mereka tidak dapat mengandalkan metode penggantian IP (proxy hopping) semata jika target *email* masih sama. Serangan *credential stuffing* besar-besaran juga di-throttle per IP, membuat *noise* percobaan massal melambat sesuai konfigurasi 60 detik per 5 *attempts*.

## Regression Result
Berjalan tanpa ada masalah pada sistem autentikasi. Validasi awal (`required`, `email`) tetap berfungsi. Session tetap di-_regenerate_ setelah _login_ yang sukses.
