# LYNVO ENERGI — SEO GROWTH DISCOVERY

## 1. Executive Summary
Berdasarkan audit read-only pada arsitektur repository Lynvo Energi (fokus pada commercial/local search intent), ditemukan sebuah *gap* kritikal pada arsitektur internal linking yang memisahkan antara "Local Landing Pages" (Money Pages) dengan "Product Catalog". 

Halaman local SEO (`toko-aki-serang`, `toko-aki-cilegon`, dll.) sudah terstruktur dengan baik (memiliki JSON-LD AutoRepair & FAQPage), namun halaman ini **tidak memberikan backlink internal (PageRank) ke halaman detail produk** yang sebenarnya. 

Fokus utama SEO Growth Phase 1 yang direkomendasikan adalah **menyambungkan Local Landing Pages ke Product Detail Pages** untuk memaksimalkan authority distribusi.

## 2. Keyword Map (Commercial / Local Intent)
Berdasarkan SERP Competitor Analysis dan struktur saat ini, target keyword komersial untuk area Banten (khususnya Serang):
- **Primary Keywords:** toko aki Serang, jual aki Serang, aki mobil Serang, toko aki terdekat Serang
- **Action/Service Keywords:** ganti aki Serang, pasang aki Serang, antar pasang aki Serang, tukar tambah aki Serang
- **Brand/Product Local Keywords:** jual aki GS Astra Serang, aki Incoe Serang, aki Amaron Serang

*Empirical GSC Data:* Unavailable (Tidak mengarang impression, click, CTR, atau ranking).

## 3. Discovery Audit: Local Landing Pages
File yang diaudit:
- `routes/web.php`
- `app/Http/Controllers/LocalSeoController.php`
- `resources/views/pages/local-landing.blade.php`
- `app/Models/CoverageArea.php`

**Temuan Positif:**
1. Routing dinamis via `/{coverageArea:slug}` (regex: `toko-aki-[a-z0-9\-]+`) telah terimplementasi dengan rapi.
2. Blade template `local-landing.blade.php` menggunakan praktik dual-keyword (Aki & Accu) pada elemen H1, H2, dan title.
3. Skema JSON-LD `AutoRepair` (LocalBusiness) dan `FAQPage` terinjeksi secara dinamis berdasarkan data `CoverageArea`.
4. BreadcrumbList schema valid dan mengarah hierarkis ke Beranda > Layanan Antar Pasang > Kota.

**Critical Gap (Peluang Utama):**
Pada bagian `<!-- POPULAR PRODUCTS CATALOG -->` di `local-landing.blade.php`, sistem memanggil 8 produk terpopuler:
```php
$popularProducts = Product::where('is_popular_retail', true)->active()->take(8)->get();
```
Namun, pada UI Card produk tersebut:
- Nama produk (`<h3>{{ $prod->name }}</h3>`) **TIDAK dibungkus** dengan link (`<a>`) menuju halaman detail produk.
- Tombol CTA utama (`Pesan & Pasang Aki Ini`) hanya berupa external link menuju WhatsApp (`whatsapp_order_url`).
- Akibatnya, `toko-aki-serang` tidak mendistribusikan link juice / authority ke `/produk/{category}/{slug}`. Mesin pencari melihat katalog produk di landing page ini sebagai dead-end (tanpa internal link), padahal halaman ini memiliki bobot SEO lokal yang tinggi.

## 4. Priority Recommendation: SEO Growth
Prioritas SEO Growth berikutnya yang memiliki dampak bisnis dan arsitektural paling besar (tanpa perlu merombak database) adalah:

**"Local Landing to Product Detail Internal Linking"**

**Action Plan:**
1. Mengubah struktur product card di `local-landing.blade.php` agar foto produk dan judul produk (`<h3>`) memiliki internal link (`href="{{ route('products.show', [$prod->category->slug, $prod->slug]) }}"`) menuju Product Detail.
2. Menyediakan 2 tombol (Dual CTA) pada card: 
   - Primary (Hijau): Pesan WhatsApp
   - Secondary (Outline/Abu-abu): "Lihat Detail" -> menuju Product Detail Page.
3. Hal ini juga berlaku di `service-hub.blade.php` (`/layanan/antar-pasang-aki`) yang menampilkan 6 featured products tanpa internal link ke product detail.

**Impact:**
- **SEO:** Merajut *Semantic Web* antara Local Search Intent (Toko Aki Serang) dengan Product Intent (Aki GS Astra NS40Z). Crawler (Googlebot) yang masuk ke landing page Serang akan langsung menemukan jalur crawl ke detail produk.
- **UX:** User yang masih ragu dapat membaca detail spesifikasi produk (CCA, Voltage) sebelum langsung klik tombol WhatsApp.

## 5. Conclusion / Status
Discovery Phase selesai. Laporan ini siap direview oleh SA.
Awaiting SA (ChatGPT) decision to proceed with the recommended action or choose another path.
