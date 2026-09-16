<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $applications = [
            [
                'name' => 'Otomotif',
                'slug' => 'otomotif',
                'hero_headline' => 'Solusi Aki Kendaraan Pribadi & Armada Operasional Ringan',
                'description' => 'Pasokan aki untuk mobil penumpang, MPV, SUV, sedan, dan mobil dinas dengan layanan antar-pasang darurat.',
                'image' => 'assets/img/applications/automotive.jpg',
                'icon' => 'car',
                'is_active' => true,
            ],
            [
                'name' => 'Truk & Bus',
                'slug' => 'truk-dan-bus',
                'hero_headline' => 'Aki Heavy Duty untuk Armada Logistik & Transportasi',
                'description' => 'Solusi daya tahan getaran tinggi dan CCA ekstra untuk armada ekspedisi, tronton, fuso, dan bus pariwisata.',
                'image' => 'assets/img/applications/truck-bus.jpg',
                'icon' => 'truck',
                'is_active' => true,
            ],
            [
                'name' => 'Alat Berat',
                'slug' => 'alat-berat',
                'hero_headline' => 'Ketahanan Ekstrem untuk Sektor Konstruksi & Pertambangan',
                'description' => 'Aki tangguh untuk excavator, bulldozer, dump truck, crane, dan wheel loader di medan operasional ekstrem.',
                'image' => 'assets/img/applications/heavy-equipment.jpg',
                'icon' => 'hard-hat',
                'is_active' => true,
            ],
            [
                'name' => 'Marine/Kapal',
                'slug' => 'marine-kapal',
                'hero_headline' => 'Daya Handal & Tahan Korosi untuk Kelautan & Maritim',
                'description' => 'Aki starter & deep cycle anti goncangan air laut untuk kapal penangkap ikan, tugboat, speedboat, dan kapal kargo.',
                'image' => 'assets/img/applications/marine.jpg',
                'icon' => 'anchor',
                'is_active' => true,
            ],
            [
                'name' => 'Genset',
                'slug' => 'genset',
                'hero_headline' => 'Starter Cepat & Pasti untuk Generator Listrik Cadangan',
                'description' => 'Aki starter genset kapasitas 20 kVA hingga 2000 kVA untuk pabrik, rumah sakit, mal, dan perhotelan.',
                'image' => 'assets/img/applications/genset.jpg',
                'icon' => 'zap',
                'is_active' => true,
            ],
            [
                'name' => 'Forklift',
                'slug' => 'forklift',
                'hero_headline' => 'Aki Starter & Traksi untuk Efisiensi Pergudangan',
                'description' => 'Solusi aki handal untuk operasional forklift di gudang logistik, pelabuhan, dan pabrik manufaktur.',
                'image' => 'assets/img/applications/forklift.jpg',
                'icon' => 'box',
                'is_active' => true,
            ],
            [
                'name' => 'Industri',
                'slug' => 'industri',
                'hero_headline' => 'Suplai Aki Kontrak B2B untuk Pabrik & Manufaktur Banten',
                'description' => 'Penyediaan aki berkala, pemeliharaan rutin, dan harga korporat untuk kawasan industri Cikande, Cilegon, dan Serang.',
                'image' => 'assets/img/applications/industry.jpg',
                'icon' => 'factory',
                'is_active' => true,
            ],
            [
                'name' => 'Telekomunikasi',
                'slug' => 'telekomunikasi',
                'hero_headline' => 'Daya Cadangan BTS & Tower Telekomunikasi',
                'description' => 'Baterai deep cycle VRLA berkualitas tinggi untuk menjaga uptime jaringan seluler dan infrastruktur BTS.',
                'image' => 'assets/img/applications/telecom.jpg',
                'icon' => 'radio',
                'is_active' => true,
            ],
            [
                'name' => 'UPS Data Center',
                'slug' => 'ups-data-center',
                'hero_headline' => 'Baterai UPS VRLA AGM & Gel untuk Server Kritis',
                'description' => 'Perlindungan terhadap lonjakan atau pemadaman listrik pada server room, data center, dan peralatan medis.',
                'image' => 'assets/img/applications/ups.jpg',
                'icon' => 'server',
                'is_active' => true,
            ],
        ];

        foreach ($applications as $app) {
            Application::updateOrCreate(['slug' => $app['slug']], $app);
        }
    }
}
