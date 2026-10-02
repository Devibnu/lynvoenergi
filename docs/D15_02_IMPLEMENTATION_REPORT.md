# D15-02 IMPLEMENTATION REPORT: Form Abuse Prevention

## 1. Scope
Tujuan dari implementasi ini adalah memperketat *rate limiting* pada endpoint `POST /inquiry` guna mencegah penyalahgunaan (spam form) tanpa mengganggu fungsi operasional bagi calon pelanggan sah, serta tanpa mengubah struktur data/skema ataupun dependensi aplikasi yang sudah ada.

## 2. Existing State
Sebelum implementasi, fungsi Rate Limiter untuk parameter `inquiry` ditetapkan sebesar `5 request per menit` berbasis IP Address. Parameter ini dirasa terlalu longgar untuk ukuran valid pengajuan *RFQ/Inquiry* B2B atau retail, yang membuka celah kecil namun signifikan terhadap serangan *spam*.

## 3. Implementation
Implementasi dilakukan HANYA pada *file configuration middleware* untuk _rate limit_, yaitu pada file `app/Providers/RouteServiceProvider.php`. Tidak ada logika di Controller maupun skema model di-ubah. Modifikasi murni bersifat konfigurasional parameter limit.

## 4. Rate Limit Decision
Parameter *Rate Limiter* telah diturunkan dari `5 per menit` menjadi `3 per menit` berdasarkan limit berbasis IP pengguna. Angka ini secara proporsional mempersempit ruang gerak pengirim *spam/bot* berkecepatan tinggi namun tetap memberi toleransi secukupnya bagi manusia.

## 5. Test Matrix
Pola _testing_ diperkenalkan pada kelas khusus `Tests\Feature\InquiryThrottleTest` serta di-update pada *existing test* `Tests\Feature\InquiryWorkflowTest`. Matriks pengujian meliputi:
- **Legitimate Request**: Pengajuan yang sah berhasil menyimpan satu data dan merespons HTTP 302 dengan pesan sukses.
- **Three Requests Allowed**: Request 1, 2, dan 3 dalam semenit dari satu IP akan dibiarkan lolos (termasuk bila ketiganya request tidak valid, tetap dianggap *attempt*).
- **Fourth Request Throttled**: Request ke-4 dan seterusnya diblokir dengan respons spesifik HTTP 429 (*Too Many Requests*).
- **Throttled Request Has No Side Effect**: Request yang ditolak tidak men-trigger duplikasi ke basis data (Side-effect aman).
- **IP Isolation**: Pengecekan limit diterapkan secara terisolasi per alamat IP.
- **Validation**: Konfirmasi bahwa input yang tidak valid tetap memakan kuota *limit* sebelum merespons HTTP 302 error-bag.
- **Decay/Reset**: *Limiter* otomatis akan membuka kembali akses setidaknya satu menit setelah pemblokiran terjadi.

## 6. Test Results
`php artisan test` menampilkan seluruh **94 tests / 301 assertions PASS** (termasuk 7 test terbaru di `InquiryThrottleTest` dan perbaikan asersi pada `InquiryWorkflowTest`). Secara spesifik:
- `Tests\Feature\InquiryThrottleTest` -> 7 PASS
- Tidak ada *regression* di fitur lain.

## 7. Security/Abuse Impact
Modifikasi konfigurasional ini bertindak sebagai mekanisme **mitigasi** efektif terhadap insiden repetitif pengiriman *spam* pada level middleware. Mengurangi _repeated submissions_ yang membebani tabel `inquiries` maupun kejelasan dashboard manajemen admin.

## 8. Limitations
- Penerapan ini belum sepenuhnya mencegah taktik penyalahgunaan (spam) apabila pelaku serangan memutasi/mengganti proxy (rotasi IP) secara konstan, karena absennya identitas berbasis sidik jari ganda (seperti parameter sesi atau reCAPTCHA).
- Modifikasi ini bukan jawaban definitif untuk isolasi problem `max_user_connections` di level _production_ (apabila itu diakibatkan _bottleneck_ yang berbeda).
- Sistem CSRF test otomatis dilewati oleh *unit test* bawaan sehingga harus disimulasikan sebagai _assumption_ dalam pengujian otomatis ini.

## 9. Files Changed
1. `app/Providers/RouteServiceProvider.php` - Modifikasi batasan limit.
2. `tests/Feature/InquiryWorkflowTest.php` - Modifikasi ekspektasi pengujian iterasi dari 5 ke 3.
3. `tests/Feature/InquiryThrottleTest.php` - (File baru) Uji eksklusif skenario throttle dan decay logic.

## 10. Final Status
Implementasi berhasil secara _read-only_ (TIDAK ADA mutasi ke target _production/commit_ dll). Status akhir: Menunggu kode *review* dari SA dan instruksi lebih lanjut.
