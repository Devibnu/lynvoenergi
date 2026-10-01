# D11 Discovery Audit Report

## 1. Kondisi Sistem Saat Ini

*   **Repository Baseline:** `8215f9a` (D10 Public Blog Integration).
*   **Production State:** Terhubung dan tersinkronisasi. Production dan local berada pada commit `8215f9a`.
*   **Test Suite:** 42 test cases (105 assertions) berjalan normal (`PASS`).
*   **Build System:** `npm run build` berjalan normal.
*   **Database:** Tidak ada migrasi tertunda. Semua tabel berada pada versi yang sesuai.

## 2. Fitur & Modul yang Tersedia

Secara keseluruhan, fitur-fitur di bawah ini telah berfungsi dan tersedia baik untuk Administrator maupun Publik (Kecuali Admin-only).

*   **User / Auth**: Login, Logout (Admin only).
*   **Setting**: Konfigurasi global, contact, SEO meta, dan business info.
*   **CompanyLocation**: Alamat dan info spesifik cabang (diintegrasikan pada halaman Kontak dan Admin).
*   **CoverageArea**: Halaman *Local SEO Landing* per area layanan.
*   **Brand**: Manajemen merek produk.
*   **Category**: Kategori produk.
*   **Product**: Katalog produk, spesifikasi, beserta relasi terhadap `Category`, `Brand`, dan `Application`.
*   **Application**: Kategori industri B2B.
*   **Project**: Portofolio pengerjaan.
*   **Article**: Sistem artikel / blog dengan SEO markup `JSON-LD`.
*   **Inquiry**: Sistem form Request for Quotation (B2B) dengan rate-limiting.

## 3. Fitur yang Belum Terintegrasi Sepenuhnya (Gaps)

*   **Sitemap SEO (`SitemapController`)**: Fitur `Article` (Blog) yang dirilis pada fase D10 belum disertakan dalam *dynamic sitemap generation* (`sitemap.xml`). Akibatnya, artikel baru tidak terdeteksi secara otomatis oleh crawler Google.

## 4. Technical Debt & Performance Concerns

*   **N+1 Query pada `Setting::getValue()` (Sangat Kritis)**
    Berdasarkan audit source code `app/Models/Setting.php`, fungsi `Setting::getValue($key)` dipanggil secara langsung ke database (`self::where('key', $key)->value('value')`).
    Pada file `resources/views/layouts/app.blade.php`, terdapat setidaknya 10-20 pemanggilan fungsi ini pada *setiap* request. Hal ini mengakibatkan terjadinya puluhan *unnecessary database query* (N+1 query issue) di seluruh website setiap kali user membuka halaman.

*   **Test Coverage (Core Models)**
    Saat ini Test Suite (`php artisan test`) terkonsentrasi pada `Brand`, `Inquiry`, `LocalSeo`, dan `Article`. Tidak ditemukan *Unit* maupun *Feature* test spesifik untuk fungsionalitas inti (Admin & Public) dari `Product`, `Category`, `Project`, maupun `Application`.

## 5. Security Concerns

*   Validasi `Input` dan otentikasi admin pada Controller secara garis besar telah sesuai standar (memanfaatkan Laravel Form Request Validation). Proteksi `Inquiry` (RFQ) juga telah dilengkapi rate limiting (throttle) untuk menghindari SPAM. Tidak ada *critical vulnerability* terbuka yang langsung terlihat pada saat ini, namun penambahan Unit Tests sangat disarankan guna mengamankan logika *edge-case*.

## 6. D11 Candidate Scope (Rekomendasi)

Berikut adalah kandidat prioritas utama untuk dikerjakan pada D11:

### 1. D11-01: Performance Optimization (Global Settings Cache)
**Objective**: Mengimplementasikan *Caching Mechanism* pada model `Setting` menggunakan `Illuminate\Support\Facades\Cache`.
**Impact**: Menghapus puluhan query redundan pada setiap *page load*, mempercepat TTFB (Time to First Byte), dan mengurangi beban server database secara masif.

### 2. D11-02: SEO Integration (Article Sitemap)
**Objective**: Mengintegrasikan `Article` (hanya `is_active = true`) ke dalam output XML `SitemapController`.
**Impact**: Melengkapi standar *Best Practice SEO* untuk modul Blog yang dirilis di D10.

### 3. D11-03: Test Coverage Expansion
**Objective**: Menambahkan *Unit* dan *Feature Tests* untuk modul inti, yakni `Product`, `Category`, dan `Project`.
**Impact**: Mencegah *regression bugs* yang berpotensi terjadi ketika dilakukan perubahan struktur / query di masa depan.

---

**Keputusan Akhir (SA)**: Dokumen ini diserahkan kepada Solution Architect (SA) untuk diputuskan mana *Candidate Scope* yang akan dieksekusi secara resmi pada fase D11.
