<?php

namespace Database\Seeders;

use App\Models\CoverageArea;
use Illuminate\Database\Seeder;

class CoverageAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            [
                'city_name' => 'Serang',
                'slug' => 'toko-aki-serang',
                'hero_title' => 'Toko Aki Serang Banten - Layanan Antar Pasang 24 Jam & Suplai B2B',
                'district_coverage' => 'Serang Kota, Cipocok Jaya, Curug, Kasemen, Taktakan, Walantaka, Ciruas, Kramatwatu, Kragilan, Baros, Petir, Pontang, Tirtayasa',
                'custom_intro_text' => 'Lynvo Energi adalah distributor dan toko aki terpercaya di Serang. Kami melayani penggantian aki mobil darurat di jalan/rumah (Home Service) serta pengadaan aki untuk instansi dan perusahaan di wilayah Serang dan sekitarnya.',
                'meta_title' => 'Toko Aki Serang 24 Jam - Distributor & Antar Pasang Aki Mobil | Lynvo Energi',
                'meta_description' => 'Pusat jual aki mobil, truk, genset & alat berat di Serang Banten. Layanan antar pasang aki cepat, garansi resmi, original GS Astra, Yuasa, Incoe, Amaron.',
                'whatsapp_number' => '6281288889999',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'city_name' => 'Cilegon',
                'slug' => 'toko-aki-cilegon',
                'hero_title' => 'Toko Aki Cilegon - Spesialis Aki Industri, Kapal, Truk & Mobil Pribadi',
                'district_coverage' => 'Cilegon Kota, Ciwandan, Pulomerak, Citangkil, Cibeber, Grogol, Jombang, Purwakarta, Kawasan Industri Krakatau Steel, Pelabuhan Merak',
                'custom_intro_text' => 'Melayani kebutuhan aki industri baja, kimia, PLTU, armada pelabuhan Merak, serta kendaraan harian masyarakat Cilegon dengan respons cepat dan produk bergaransi resmi.',
                'meta_title' => 'Toko Aki Cilegon - Suplai Aki Industri, Marine & Antar Pasang Mobil | Lynvo Energi',
                'meta_description' => 'Distributor aki resmi di Kota Cilegon. Siap suplai aki pabrik, kapal maritim, forklift, truk tronton dan antar pasang aki mobil 24 jam.',
                'whatsapp_number' => '6281288889999',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'city_name' => 'Cikande',
                'slug' => 'toko-aki-cikande',
                'hero_title' => 'Toko Aki Cikande Modern - Vendor Aki Pabrik, Logistik & Alat Berat Kawasan Industri',
                'district_coverage' => 'Kawasan Industri Modern Cikande, Cikande Permai, Kibin, Jawilan, Kopo, Pamarayan, Kragilan, Tambak, Binuang',
                'custom_intro_text' => 'Mitra strategis ratusan pabrik di Kawasan Industri Modern Cikande. Kami menyediakan aki genset industri, aki forklift elektrik/diesel, aki armada truk tronton ekspedisi dengan sistem pembayaran PO/kontrak tempo B2B.',
                'meta_title' => 'Toko Aki Cikande Modern - Distributor Aki Pabrik, Forklift & Truk | Lynvo Energi',
                'meta_description' => 'Pusat aki kawasan industri Modern Cikande Serang. Suplai aki B2B kontrak perusahaan, genset pabrik, forklift, armada logistik bergaransi resmi.',
                'whatsapp_number' => '6281288889999',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'city_name' => 'Tangerang',
                'slug' => 'toko-aki-tangerang',
                'hero_title' => 'Toko Aki Tangerang Raya - Layanan Cepat Antar Pasang Aki Mobil & Heavy Duty',
                'district_coverage' => 'Balaraja, Cikupa, Pasar Kemis, Tigaraksa, Jayanti, Curug, Karawaci, Tangerang Kota, BSD Serpong, Alam Sutera, Batuceper, Ciledug',
                'custom_intro_text' => 'Solusi aki terlengkap untuk kawasan industri Balaraja - Cikupa hingga residensial Tangerang Raya. Teknisi profesional siap meluncur ke lokasi Anda untuk cek kelistrikan dan pasang aki baru.',
                'meta_title' => 'Toko Aki Tangerang - Distributor Resmi & Layanan Delivery Aki 24 Jam | Lynvo Energi',
                'meta_description' => 'Jual aki mobil, truk, genset & forklift murah original di Tangerang. Layanan antar pasang darurat cepat, garansi resmi, tukar tambah aki bekas diterima tinggi.',
                'whatsapp_number' => '6281288889999',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($areas as $area) {
            CoverageArea::updateOrCreate(['slug' => $area['slug']], $area);
        }
    }
}
