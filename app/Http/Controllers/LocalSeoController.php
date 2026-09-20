<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocalSeoController extends Controller
{
    /**
     * Display a specific local landing (Money Page) for a Banten coverage area.
     */
    public function showLocalLanding(string $slug): View
    {
        $area = CoverageArea::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $popularProducts = Product::where('is_popular_retail', true)
            ->active()
            ->with(['category'])
            ->take(8)
            ->get();

        $otherAreas = CoverageArea::active()
            ->where('id', '!=', $area->id)
            ->orderBy('sort_order')
            ->get();

        // SEO Meta defaults
        $metaTitle = $area->meta_title ?: "Toko Aki & Accu {$area->city_name} — Layanan Antar Pasang 24 Jam | Lynvo Energi";
        $metaDescription = $area->meta_description ?: "Pusat jual beli aki dan accu mobil, truk, genset di {$area->city_name} Banten. Layanan pesan antar pasang aki darurat cepat, garansi resmi original GS Astra, Yuasa, Incoe, Amaron.";

        // JSON-LD LocalBusiness / AutoRepair Schema
        $schemaLocalBusiness = [
            '@context' => 'https://schema.org',
            '@type' => 'AutoRepair',
            'name' => "Lynvo Energi - Toko Aki & Accu {$area->city_name}",
            'image' => asset('assets/img/lynvo-store.jpg'),
            'description' => $metaDescription,
            'telephone' => '+' . \App\Models\Setting::getNormalizedWhatsappNumber(),
            'priceRange' => 'Rp 700.000 - Rp 3.500.000',
            'areaServed' => [
                '@type' => 'AdministrativeArea',
                'name' => "{$area->city_name}, Banten",
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $area->city_name,
                'addressRegion' => 'Banten',
                'addressCountry' => 'ID',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '-6.1200',
                'longitude' => '106.1500',
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ],
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Layanan & Produk Aki Accu',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Layanan Antar Pasang Aki Mobil di Tempat',
                            'description' => 'Teknisi datang ke rumah, kantor, atau lokasi mogok jalan raya untuk pasang aki baru dan tes dinamo alternator gratis.',
                        ],
                    ],
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Product',
                            'name' => 'Aki Mobil & Truk Bergaransi Resmi',
                            'description' => 'Aki kering MF dan konvensional GS Astra, Yuasa, Incoe, Amaron, Varta 100% original.',
                        ],
                    ],
                ],
            ],
        ];

        // JSON-LD FAQ Schema
        $faqs = [
            [
                'question' => "Berapa lama estimasi teknisi sampai ke lokasi di area {$area->city_name}?",
                'answer' => "Estimasi tim teknisi Lynvo Energi tiba di lokasi Anda di wilayah {$area->city_name} adalah 30 hingga 60 menit setelah konfirmasi pesanan via WhatsApp/Telepon, tergantung kondisi lalu lintas.",
            ],
            [
                'question' => "Apakah ada biaya tambahan untuk jasa antar dan pasang aki?",
                'answer' => "Tidak ada biaya tersembunyi. Layanan antar, pasang di tempat, reset kelistrikan standar, serta pengecekan alternator/dinamo ampere diberikan GRATIS untuk seluruh area jangkauan kami di {$area->city_name}.",
            ],
            [
                'question' => "Apakah bisa tukar tambah dengan aki / accu bekas saya yang sudah mati?",
                'answer' => "Bisa sekali! Kami menerima tukar tambah (trade-in) aki bekas Anda dengan potongan harga langsung hingga Rp 50.000 s/d Rp 250.000 tergantung ukuran dan kapasitas ampere aki lama Anda.",
            ],
            [
                'question' => "Merk aki dan accu apa saja yang tersedia?",
                'answer' => "Kami menyediakan merk terkemuka 100% original dan bergaransi resmi: GS Astra, Yuasa, Incoe, Amaron, Varta, Bosch, Panasonic, dan Delkor untuk mobil bensin, diesel, truk, genset, hingga alat berat.",
            ],
            [
                'question' => "Metode pembayaran apa saja yang diterima?",
                'answer' => "Pembayaran dapat dilakukan setelah aki selesai dipasang dan dites kelistrikannya dengan baik di lokasi Anda (Cash / Tunai, Transfer Bank BCA/Mandiri/BRI, QRIS, atau Kartu).",
            ],
        ];

        $schemaFaq = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ];
            }, $faqs),
        ];

        return view('pages.local-landing', [
            'area' => $area,
            'popularProducts' => $popularProducts,
            'otherAreas' => $otherAreas,
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'schemaLocalBusiness' => $schemaLocalBusiness,
            'schemaFaq' => $schemaFaq,
            'faqs' => $faqs,
        ]);
    }

    /**
     * Display the main service hub overview for battery delivery across Banten.
     */
    public function serviceHub(): View
    {
        $coverageAreas = CoverageArea::active()
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::where('is_popular_retail', true)
            ->active()
            ->with(['category'])
            ->take(6)
            ->get();

        $metaTitle = "Layanan Pesan Antar Pasang Aki Mobil & Truk 24 Jam Se-Banten | Lynvo Energi";
        $metaDescription = "Layanan darurat antar dan ganti aki / accu mobil, truk, genset di Serang, Cilegon, Cikande, Tangerang dan sekitarnya. Teknisi datang cepat, gratis pasang & cek alternator.";

        return view('pages.service-hub', [
            'coverageAreas' => $coverageAreas,
            'featuredProducts' => $featuredProducts,
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
        ]);
    }
}
