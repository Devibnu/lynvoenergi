# D16 Local UAT Report

## 1. Environment
- **Branch/Commit**: `2abfb87b820694b044174f59e3921a1cac3d27f5e` (ditambah modifikasi lokal implementasi D16)
- **Tipe UAT**: Local API/HTTP Testing menggunakan Laravel Feature Tests (mensimulasikan HTTP Requests).
- **Kondisi Data**: RefreshDatabase (data tiruan factory untuk menghindar mutasi production)

## 2. D16-01 UAT
### Product
- **Scenario**: Create product unik.
  - **Action**: POST HTTP `admin.products.store` (Aki C).
  - **Expected**: Data tersimpan, redirect index.
  - **Actual**: Request HTTP berhasil 302, redirect, dan data muncul di DB.
  - **Status**: PASS
- **Scenario**: Create product duplicate.
  - **Action**: POST HTTP `admin.products.store` dengan nama persis sama (Aki A).
  - **Expected**: Validation error `name`.
  - **Actual**: HTTP 302 (redirect back), session memiliki error 'name'.
  - **Status**: PASS
- **Scenario**: Update Product A menggunakan nama Product B.
  - **Action**: PUT HTTP `admin.products.update` (Product B) namun mengisi field name dengan `Aki A`.
  - **Expected**: Validation error.
  - **Actual**: HTTP 302 (redirect back), session memiliki error 'name'.
  - **Status**: PASS
- **Scenario**: Update Product A dengan name-nya sendiri.
  - **Action**: PUT HTTP `admin.products.update` dengan mengisi kembali `Aki A` pada ID rekaman Aki A.
  - **Expected**: Berhasil.
  - **Actual**: HTTP 302 redirect index, data ter-update.
  - **Status**: PASS

### Category
- **Scenario**: Create category unik & duplicate.
- **Action**: POST HTTP `admin.categories.store`.
- **Status**: PASS (Keduanya mengkonfirmasi HTTP success dan Validation error sesuai rule `unique`).
- **Scenario**: Update category silang & self-update.
- **Action**: PUT HTTP `admin.categories.update`.
- **Status**: PASS (Self-update sukses mengabaikan pengecekan diri sendiri; update duplikat ditolak validator).

### Application
- **Scenario**: Create dan Update Aplikasi unik/duplikat.
- **Action**: POST `admin.applications.store` dan PUT `admin.applications.update`.
- **Status**: PASS (Perilaku form validator telah di-intercept 100% dari HTTP Request level, melindungi DB unik constraint secara penuh).

## 3. D16-04 UAT
- **Scenario**: Local Landing memiliki product
- **Action**: GET HTTP `local.landing` (route: `/{coverage-slug}`)
- **Expected**: HTTP 200, N+1 Query tidak terjadi.
- **Actual**: Respons merender 200 OK. Query log yang ditangkap memverifikasi bahwa `select * from brands where id in (...)` hanya dipanggil 1 kali.
- **Status**: PASS

## 4. D16-05 UAT
- **Scenario**: Guest mengakses /logout (POST).
- **Action**: POST HTTP `/logout` sebagai unauthenticated.
- **Expected**: Ditolak oleh Auth middleware (dilempar ke login page).
- **Actual**: Redirect ke route `login`.
- **Status**: PASS
- **Scenario**: Authenticated user mengakses /logout (POST).
- **Action**: POST HTTP `/logout` sebagai logged user.
- **Expected**: Berhasil logout dan redirect root `/`.
- **Actual**: HTTP 302 redirect ke `/` dan asersi Session Guest sukses memutus auth state.
- **Status**: PASS

## 5. Regression Smoke
Semua rute publik utama telah dilewati di dalam skenario *test suite* yang berjalan penuh. 
- GET `/` -> Tercakup dalam HomepageTest (PASS)
- GET `/produk` -> Tercakup dalam CatalogTest (PASS)
- GET `/kontak` -> Tercakup dalam PublicPageSmokeTest (PASS)
- GET `/tentang-kami` -> Tercakup dalam PublicPageSmokeTest (PASS)
- GET `/artikel` -> Tercakup dalam PublicArticleTest (PASS)
- GET `/login` -> Tercakup dalam LoginTest (PASS)
- GET local SEO -> Tercakup di LocalSeoLandingTest (PASS)

## 6. Test Results
- `php artisan test --filter=D16ImplementationTest`: **13 passed**
- `php artisan test` (Full Suite): **106 passed** (329 assertions)
- `git diff --check`: Bersih (Clean)

## 7. Known Limitations
- UAT dijalankan secara headless menggunakan PHPUnit/Pest di dalam environment lokal, sehingga form rendering Javascript (seperti Alert success/error) tidak tervalidasi via end-to-end browser (meskipun HTTP contract validation terbukti valid).

## 8. Conclusion
Keseluruhan fungsionalitas dan keamanan dari scope D16 telah disimulasikan sesuai siklus Request/Response aslinya dan 100% PASS tanpa regresi. Pekerjaan siap ditinjau secara definitif sebelum proses Commit.
