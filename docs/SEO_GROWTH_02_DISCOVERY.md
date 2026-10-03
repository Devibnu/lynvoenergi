# SEO Growth 02 Discovery

## 1. Scope
Discovery ini bertujuan memetakan graph internal link aktual dan mengidentifikasi peluang SEO Growth (SEO Growth 02) selanjutnya untuk Lynvo Energi, berdasarkan data dan template yang ada di repository (READ-ONLY). Fokus utamanya adalah memperkuat aliran otoritas (link equity) menuju halaman-halaman komersial.

## 2. Current SEO Architecture
- Halaman katalog utama (`products.index`) bertindak sebagai hub besar.
- Terdapat halaman spesifik per Brand (`brands.show`).
- Terdapat halaman spesifik Local SEO (`local.landing`).
- Sebagian besar halaman sudah memiliki Schema JSON-LD (LocalBusiness, FAQ, Breadcrumb).
- *D19* telah memastikan `Product Detail -> Brand` memiliki link.
- *SEO Growth 01* telah memastikan `Local Landing -> Product Detail` memiliki link.

## 3. Internal Link Graph Findings
- **Homepage → Local Landing**: Tersedia via navigasi (header/footer).
- **Homepage → Category**: Tersedia di grid kategori spesial.
- **Homepage → Brand**: **Tidak ditemukan** link langsung (seksi "Our Brands" tidak terpetakan dengan baik sebagai internal link).
- **Local Landing → Category**: **Gaps** (Tidak ada direct link ke katalog spesifik dari body landing, hanya homepage/header).
- **Local Landing → Brand**: **Gaps** (Nama brand di product card berupa `<span>` statis).
- **Local Landing → Product**: Tersedia (hasil SEO Growth 01).
- **Category → Product**: Tersedia (via grid katalog).
- **Category → Brand**: **Gaps** (Nama brand di product card katalog berupa `<span>` statis).
- **Brand → Product**: Tersedia (via product listing di brand page).
- **Product → Category**: Tersedia (di breadcrumb & metadata).
- **Product → Brand**: Tersedia (hasil D19).
- **Article → commercial pages**: **Gaps** (Artikel hanya memiliki action_url tunggal, tidak ada blok produk/brand terkait).

## 4. Commercial Page Findings
Halaman Brand (`brands.show`) adalah halaman komersial dengan nilai pencarian tinggi (misal: "Aki GS Astra", "Aki Yuasa"). Saat ini, halaman Brand kurang mendapatkan asupan internal link dari halaman dengan traffic tinggi seperti Homepage, Local Landing, atau Catalog.

## 5. Category Findings
Halaman Katalog (`products/index.blade.php`) merender puluhan/ratusan kartu produk. Pada setiap kartu, terdapat atribut brand (misalnya `{{ $product->getRelationValue('brand')?->name }}`). Atribut ini dirender menggunakan tag HTML `<span>` dan bukan `<a>`. Ini menghilangkan potensi ratusan internal link menuju halaman `brands.show`.

## 6. Brand Findings
Brand page hampir menjadi *near-orphan* dari sisi hierarki top-down. Hanya bisa diakses dari halaman Daftar Merek (`brands.index`) dan Product Detail (D19). Halaman ini membutuhkan suntikan otoritas dari halaman hub yang lebih tinggi.

## 7. Local Landing Findings
Halaman Local Landing (`local-landing.blade.php`) menampilkan popular products. Sama halnya dengan halaman kategori, label brand pada kartu produk masih menggunakan `<span>` statis.

## 8. Article → Commercial Findings
Halaman edukasi/artikel (`articles.show`) memiliki *prose* (konten teks panjang) namun tidak mengkonversi intent informasional ke komersial melalui komponen internal linking struktural (seperti "Produk Terkait" atau "Brand Terkait").

## 9. Top 3 SEO Opportunities

### Opportunity 1: Category to Brand Internal Linking (Catalog Product Cards)
- **Finding**: Nama brand di setiap product card pada halaman katalog (`products/index.blade.php`) dirender sebagai `<span>` statis.
- **Current State**: Menggunakan tag `<span class="px-2.5 py-1... bg-blue-100...">{{ $product->getRelationValue('brand')?->name }}</span>`
- **SEO Impact**: High. Akan menginjeksi ratusan/ribuan link equity dari halaman katalog ke halaman brand.
- **Search Intent**: Commercial intent (Mendorong pengguna filter katalog masuk ke halaman spesifik merek).
- **Implementation Complexity**: Low. Hanya modifikasi Blade template.
- **Risk**: Very Low.
- **Opportunity Score**: 9/10
- **Recommendation**: Jadikan `<a>` yang mengarah ke `route('brands.show', $product->brand->slug)`.

### Opportunity 2: Local Landing to Brand Internal Linking
- **Finding**: Nama brand di product card pada bagian "Pilihan Aki / Accu Terlaris" di `local-landing.blade.php` masih statis.
- **Current State**: Menggunakan `<span>{{ $prod->getRelationValue('brand')?->name ?? 'Aki Resmi' }}</span>`
- **SEO Impact**: Medium to High. Mendistribusikan *local search authority* ke otoritas *brand*.
- **Search Intent**: Local Commercial intent.
- **Implementation Complexity**: Low.
- **Risk**: Very Low.
- **Opportunity Score**: 8/10
- **Recommendation**: Ubah `<span>` menjadi `<a>` ke `brands.show` dengan penanganan fallback (apabila brand null).

### Opportunity 3: Homepage to Brand Carousel/Grid Links
- **Finding**: Halaman utama (`home.blade.php`) tidak memiliki struktur link langsung menuju *brand pages*, menyebabkan link equity homepage tidak mengalir langsung ke merek.
- **Current State**: Tidak ada `<a href="{{ route('brands.show', ...) }}">` di halaman utama.
- **SEO Impact**: Medium.
- **Search Intent**: Navigational / Commercial.
- **Implementation Complexity**: Medium (Perlu mengambil data brands di `HomeController` dan membuat UI).
- **Risk**: Low (Namun memerlukan sedikit perombakan desain homepage).
- **Opportunity Score**: 7/10
- **Recommendation**: Tambahkan Brand Section di Homepage.

## 10. Priority Ranking

| Rank | Opportunity | Impact | Complexity | Risk | Priority |
|------|-------------|--------|------------|------|----------|
| 1 | Category to Brand Internal Linking | High | Low | Very Low | P1 |
| 2 | Local Landing to Brand Internal Linking | High | Low | Very Low | P2 |
| 3 | Homepage to Brand Section | Medium | Medium | Low | P3 |

## 11. Recommended Next SEO Growth

**Category to Brand Internal Linking (Products Catalog)**

- **Why this one**: Halaman Katalog Produk adalah Hub komersial terbesar dengan jumlah iterasi product card terbanyak.
- **Expected SEO benefit**: Setiap product card di halaman katalog akan menyumbang 1 *follow link* ke halaman Brand, langsung menciptakan ratusan arsitektur penghubung baru (*flat architecture*) yang sangat *crawlable* oleh Googlebot.
- **Why now**: Melanjutkan suksesi D19 (Product Detail -> Brand) yang telah selesai, sangat logis untuk menyempurnakan alur ini dari tingkat direktori yang lebih tinggi (Katalog).
- **Why not the other two**: Local Landing to Brand (P2) sangat bagus namun skalanya lebih kecil (hanya 4 popular products per local page). Homepage to Brand (P3) membutuhkan effort perancangan komponen UI baru, tidak sekadar mengganti `<span>` menjadi `<a>`.
- **Scope boundary**: Modifikasi file `resources/views/pages/products/index.blade.php` pada perulangan grid produk.

## 12. SA Recommendation

- **SA DECISION**: AWAITING SA INPUT
- **Recommended next phase**: IMPLEMENTATION
- **Implementation boundary**: Blade view `resources/views/pages/products/index.blade.php` (hanya bagian badge brand pada grid product card).
- **Files likely affected**:
  - `resources/views/pages/products/index.blade.php`
  - Unit Test terkait (jika ada *view assertions*).
- **Database impact**: NO
- **URL architecture impact**: NO (menggunakan existing route `brands.show`).
- **SEO risk**: VERY LOW (Hanya penguatan internal link, tidak merusak struktur kanonikal atau JSON-LD).
