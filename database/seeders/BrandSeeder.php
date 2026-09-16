<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'GS Astra',
                'slug' => 'gs-astra',
                'logo' => 'assets/img/brands/gs-astra.png',
                'description' => 'Brand aki OEM nomor satu di Indonesia dengan standar kualitas Astra Otoparts & ketahanan teruji.',
                'is_featured' => true,
            ],
            [
                'name' => 'Yuasa',
                'slug' => 'yuasa',
                'logo' => 'assets/img/brands/yuasa.png',
                'description' => 'Aki teknologi Jepang dengan performa starter tangguh dan daya tahan luar biasa untuk mobil, motor & genset.',
                'is_featured' => true,
            ],
            [
                'name' => 'Incoe',
                'slug' => 'incoe',
                'logo' => 'assets/img/brands/incoe.png',
                'description' => 'Aki kualitas ekspor dari Astra Otoparts, efisien, handal untuk kendaraan komersial, truk, dan perkebunan.',
                'is_featured' => true,
            ],
            [
                'name' => 'Amaron',
                'slug' => 'amaron',
                'logo' => 'assets/img/brands/amaron.png',
                'description' => 'Aki dengan teknologi SilvenX Alloy tahan panas tropis ekstrem dengan garansi terpanjang di kelasnya.',
                'is_featured' => true,
            ],
            [
                'name' => 'Varta',
                'slug' => 'varta',
                'logo' => 'assets/img/brands/varta.png',
                'description' => 'Aki premium Jerman spesialis kendaraan Eropa dan mobil modern dengan teknologi Start-Stop AGM/EFB.',
                'is_featured' => true,
            ],
            [
                'name' => 'Bosch',
                'slug' => 'bosch',
                'logo' => 'assets/img/brands/bosch.png',
                'description' => 'Aki bebas perawatan (Maintenance-Free) berteknologi Jerman untuk performa kelistrikan stabil dan responsif.',
                'is_featured' => false,
            ],
            [
                'name' => 'Panasonic',
                'slug' => 'panasonic',
                'logo' => 'assets/img/brands/panasonic.png',
                'description' => 'Aki Calcium MF dengan kepadatan daya tinggi dan charging acceptance cepat buatan Panasonic.',
                'is_featured' => false,
            ],
            [
                'name' => 'Delkor',
                'slug' => 'delkor',
                'logo' => 'assets/img/brands/delkor.png',
                'description' => 'Aki impor Korea kualitas Clarios bersertifikat global untuk kendaraan premium dan operasional berat.',
                'is_featured' => false,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }
    }
}
