<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'GS Astra NS40Z',
                'brand' => 'GS Astra',
                'official_brand' => 'GS Astra',
                'category_id' => 1, // Aki Mobil
                'voltage' => '12V',
                'capacity_ah' => 35,
                'cca' => 320,
                'compatibility' => 'Avanza, Xenia, Rush, Terios, Carry',
                'price' => 750000,
                'is_price_visible' => true,
                'is_active' => true,
                'applications' => [1], // Otomotif
            ],
            [
                'name' => 'Incoe Gold N200',
                'brand' => 'Incoe',
                'official_brand' => 'Incoe',
                'category_id' => 2, // Aki Truk & Bus
                'voltage' => '12V',
                'capacity_ah' => 200,
                'cca' => 1100,
                'compatibility' => 'Hino Ranger, Mitsubishi Fuso, Excavator Komatsu',
                'price' => 2350000,
                'is_price_visible' => true,
                'is_active' => true,
                'applications' => [2, 3], // Truk & Bus, Alat Berat
            ],
            [
                'name' => 'Yuasa Pafecta N120',
                'brand' => 'Yuasa',
                'official_brand' => 'Yuasa',
                'category_id' => 4, // Aki Kapal
                'voltage' => '12V',
                'capacity_ah' => 120,
                'cca' => 800,
                'compatibility' => 'Mesin Tempel Yamaha, Genset Diesel 20kVA',
                'price' => 1700000,
                'is_price_visible' => false,
                'is_active' => true,
                'applications' => [4, 5], // Marine/Kapal, Genset
            ],
            [
                'name' => 'Amaron Quanta 12V 100Ah',
                'brand' => 'Amaron',
                'official_brand' => 'Amaron',
                'category_id' => 6, // Aki UPS
                'voltage' => '12V',
                'capacity_ah' => 100,
                'cca' => null,
                'compatibility' => 'UPS APC, Data Center Server Racks, BTS Tower',
                'price' => 2100000,
                'is_price_visible' => true,
                'is_active' => true,
                'applications' => [8, 9], // Telekomunikasi, UPS Data Center
            ],
            [
                'name' => 'Massiv Amal N70Z',
                'brand' => 'Massiv',
                'official_brand' => 'Yuasa',
                'category_id' => 3, // Aki Alat Berat
                'voltage' => '12V',
                'capacity_ah' => 75,
                'cca' => 550,
                'compatibility' => 'Forklift Diesel Kecil, Mini Excavator',
                'price' => 1150000,
                'is_price_visible' => true,
                'is_active' => true,
                'applications' => [3, 6], // Alat Berat, Forklift
            ]
        ];

        foreach ($products as $data) {
            $apps = $data['applications'];
            unset($data['applications']);
            
            $officialBrand = Brand::where('name', $data['official_brand'])->firstOrFail();
            $data['brand_id'] = $officialBrand->id;
            unset($data['official_brand']);
            
            $data['slug'] = Str::slug($data['name']);
            
            $product = Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
            $product->applications()->sync($apps);
        }
    }
}
