<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_logo', 'label' => 'Logo Website', 'value' => ''],
            ['key' => 'site_favicon', 'label' => 'Favicon Website', 'value' => ''],
            ['key' => 'site_whatsapp', 'label' => 'Nomor WhatsApp Utama', 'value' => '6281234567890'],
            ['key' => 'hero_phone', 'label' => 'Nomor Telepon Hero (24/7)', 'value' => '0812-8888-9999'],
            ['key' => 'site_email', 'label' => 'Email Perusahaan', 'value' => 'info@lynvoenergi.com'],
            ['key' => 'promo_text', 'label' => 'Teks Promo Top Bar', 'value' => 'Aki Mobil Drop / Mogok di Banten? Teknisi kami siap antar & pasang sekarang juga!'],
            ['key' => 'company_name', 'label' => 'Nama Perusahaan', 'value' => 'PT. LYNVO ENERGI'],
            ['key' => 'brand_name', 'label' => 'Nama Brand', 'value' => 'Lynvo Energi'],
            ['key' => 'company_description', 'label' => 'Deskripsi Perusahaan', 'value' => 'Spesialis Baterai & Aki Industri'],
            ['key' => 'office_address', 'label' => 'Alamat Kantor & Gudang', 'value' => 'Jl. Kp. Nyamuk, Margagiri, Kec. Bojonegara, Kabupaten Serang, Banten 42454'],
            ['key' => 'b2b_phone', 'label' => 'Telepon Kantor (B2B Procurement)', 'value' => '081384474349'],
            ['key' => 'business_hours', 'label' => 'Jam Operasional', 'value' => 'Senin - Jumat, 09:00 - 17:00'],
            ['key' => 'emergency_service_enabled', 'label' => 'Layanan Darurat Aktif (1/0)', 'value' => '1'],
            ['key' => 'emergency_service_text', 'label' => 'Teks Layanan Darurat', 'value' => 'Aki mogok di jalan atau lokasi proyek? Tim teknisi kami siap membantu dengan layanan antar dan pemasangan aki.'],
            ['key' => 'site_linkedin', 'label' => 'URL LinkedIn', 'value' => 'https://linkedin.com/company/lynvoenergi'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
