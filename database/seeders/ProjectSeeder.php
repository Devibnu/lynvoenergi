<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title'           => 'Suplai & Instalasi Aki Starter Genset Standby 1000 kVA Kawasan Industri',
                'slug'            => 'suplai-instalasi-aki-starter-genset-standby-1000kva-kawasan-industri',
                'client_name'     => 'PT Surya Mega Manufaktur Cikande',
                'location'        => 'Kawasan Industri Modern Cikande, Banten',
                'description'     => 'Pemasangan bank baterai starter genset Cummins 1000 kVA menggunakan 4 unit GS Astra N200 Heavy Duty lengkap dengan penggantian kabel terminal tembaga murni dan pengujian starting voltage otomatis.',
                'image'           => 'https://placehold.co/600x400/0f172a/ffffff?text=Proyek+Pabrik',
                'is_published'    => true,
            ],
            [
                'title'           => 'Pengadaan Baterai Heavy Duty Fleet Truk Ekspedisi Logistik (50 Unit)',
                'slug'            => 'pengadaan-baterai-heavy-duty-fleet-truk-ekspedisi-logistik',
                'client_name'     => 'PT Mitra Trans Logistik Banten',
                'location'        => 'Cikande, Serang - Banten',
                'description'     => 'Penyediaan dan instalasi bertahap 50 unit aki GS Astra Premium N100 dan Incoe Gold N70Z untuk peremajaan armada truk Fuso dan Hino Dutro ekspedisi lintas Jawa-Sumatera dengan fasilitas monitoring berkala.',
                'image'           => 'https://placehold.co/600x400/0f172a/ffffff?text=Proyek+Armada+Truk',
                'is_published'    => true,
            ],
            [
                'title'           => 'Pengadaan Baterai Alat Berat Excavator & Bulldozer Pertambangan Pasir',
                'slug'            => 'pengadaan-baterai-alat-berat-excavator-pertambangan-pasir',
                'client_name'     => 'PT Banten Karya Mandiri',
                'location'        => 'Rangkasbitung & Cilegon, Banten',
                'description'     => 'Kontrak pengadaan berkala aki Yuasa Heavy Duty N150 dan N200 untuk operasional 18 unit Excavator Komatsu PC200 dan CAT 320 dengan ketahanan getaran medan pertambangan ekstrem.',
                'image'           => 'https://placehold.co/600x400/0f172a/ffffff?text=Proyek+Alat+Berat',
                'is_published'    => true,
            ],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }
    }
}
