<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Support\Str;
use RuntimeException;

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
                'category_slug' => 'aki-mobil',
                'official_brand' => 'GS Astra',
                'voltage' => '12V',
                'capacity_ah' => 35,
                'cca' => 320,
                'compatibility' => 'Avanza, Xenia, Rush, Terios, Carry',
                'price' => 750000,
                'is_price_visible' => true,
                'is_active' => true,
                'application_slugs' => ['otomotif'],
            ],
            [
                'name' => 'Incoe Gold N200',
                'category_slug' => 'aki-truk-bus',
                'official_brand' => 'Incoe',
                'voltage' => '12V',
                'capacity_ah' => 200,
                'cca' => 1100,
                'compatibility' => 'Hino Ranger, Mitsubishi Fuso, Excavator Komatsu',
                'price' => 2350000,
                'is_price_visible' => true,
                'is_active' => true,
                'application_slugs' => ['truk-dan-bus', 'alat-berat'],
            ],
            [
                'name' => 'Yuasa Pafecta N120',
                'category_slug' => 'aki-marine',
                'official_brand' => 'Yuasa',
                'voltage' => '12V',
                'capacity_ah' => 120,
                'cca' => 800,
                'compatibility' => 'Mesin Tempel Yamaha, Genset Diesel 20kVA',
                'price' => 1700000,
                'is_price_visible' => false,
                'is_active' => true,
                'application_slugs' => ['marine-kapal', 'genset'],
            ],
            [
                'name' => 'Amaron Quanta 12V 100Ah',
                'category_slug' => 'aki-industri-deep-cycle',
                'official_brand' => 'Amaron',
                'voltage' => '12V',
                'capacity_ah' => 100,
                'cca' => null,
                'compatibility' => 'UPS APC, Data Center Server Racks, BTS Tower',
                'price' => 2100000,
                'is_price_visible' => true,
                'is_active' => true,
                'application_slugs' => ['telekomunikasi', 'ups-data-center'],
            ],
            [
                'name' => 'Massiv Amal N70Z',
                'category_slug' => 'aki-alat-berat',
                'official_brand' => 'Yuasa',
                'voltage' => '12V',
                'capacity_ah' => 75,
                'cca' => 550,
                'compatibility' => 'Forklift Diesel Kecil, Mini Excavator',
                'price' => 1150000,
                'is_price_visible' => true,
                'is_active' => true,
                'application_slugs' => ['alat-berat', 'forklift'],
            ]
        ];

        foreach ($products as $data) {
            $category = Category::where('slug', $data['category_slug'])->firstOrFail();
            $brand = Brand::where('name', $data['official_brand'])->firstOrFail();

            $applications = Application::whereIn('slug', $data['application_slugs'])->pluck('id');

            if ($applications->count() !== count($data['application_slugs'])) {
                throw new RuntimeException("One or more applications could not be resolved for product: {$data['name']}");
            }

            $data['category_id'] = $category->id;
            $data['brand_id'] = $brand->id;

            $apps = $applications->toArray();

            unset($data['category_slug']);
            unset($data['official_brand']);
            unset($data['application_slugs']);
            
            $data['slug'] = Str::slug($data['name']);
            
            $product = Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
            $product->applications()->sync($apps);
        }
    }
}
