# D14-02 IMPLEMENTATION REPORT: ENV ACCESS HARDENING

## 1. Finding
**BCK-01** — Penggunaan `env()` di luar file konfigurasi.

## 2. Root Cause
Aplikasi menggunakan pemanggilan fungsi `env()` secara langsung di controller dan scheduler (`Kernel.php`). Hal ini bermasalah karena jika perintah `php artisan config:cache` dijalankan di environment production (untuk optimasi), maka semua fungsi `env()` akan mengembalikan nilai `null`. Akibatnya logika aplikasi dapat mengalami kegagalan fungsi (contoh: kondisi `env('IS_DEMO')` akan selalu salah).

## 3. Direct env() Usage (Sebelum Perubahan)
1. `app/Console/Kernel.php` (Line 30) - `if(env('IS_DEMO')) { ... }`
2. `app/Http/Controllers/InfoUserController.php` (Line 31) - `if(env('IS_DEMO') && Auth::user()->id == 1) { ... }`
3. `app/Http/Controllers/ResetController.php` (Line 19) - `if(env('IS_DEMO')) { ... }`

## 4. Config Mapping
| ENV Key | Original Usage | Mapped Config | Status |
| --- | --- | --- | --- |
| `IS_DEMO` | `env('IS_DEMO')` | `config('demo.enabled')` | **New file (`config/demo.php`)** |

Sesuai instruksi, file `config/demo.php` baru dibuat dengan struktur:
```php
return [
    'enabled' => env('IS_DEMO', false),
];
```

## 5. Files Changed
- **MODIFIED**:
  - `app/Console/Kernel.php`
  - `app/Http/Controllers/InfoUserController.php`
  - `app/Http/Controllers/ResetController.php`
- **ADDED**:
  - `config/demo.php`
  - `tests/Feature/ConfigDemoTest.php`

## 6. Tests
Satu _focused test_ (`Tests\Feature\ConfigDemoTest`) ditambahkan untuk secara khusus menguji simulasi _demo config_. Test memodifikasi secara virtual via `Config::set('demo.enabled', ...)` untuk membuktikan bahwa Controller benar-benar membaca Config, dan bukan `env()` langsung.

## 7. Regression Result
- `ConfigDemoTest`: **PASS** (1 test, 2 assertions).
- Full Test Suite (`php artisan test`): **PASS** (82 tests, 244 assertions).
- `git diff --check`: **PASS** (Clean).

## 8. Config Cache Compatibility Verification
Seluruh titik di mana nilai `IS_DEMO` dicek sekarang sepenuhnya mendukung integrasi dengan *config cache* Laravel. Jika _framework_ men-_serialize_ isi config saat _deployment production_, data `demo.enabled` akan terangkut dengan baik dan logika _conditional demo_ akan berfungsi normal.
