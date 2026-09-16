<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['key' => 'promo_text', 'label' => 'Teks Promo Top Bar', 'value' => 'Aki Mobil Drop / Mogok di Banten? Teknisi kami siap antar & pasang sekarang juga!']
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
