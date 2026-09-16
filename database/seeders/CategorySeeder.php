<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Aki Mobil', 'slug' => 'aki-mobil'],
            ['name' => 'Aki Truk & Bus', 'slug' => 'aki-truk-bus'],
            ['name' => 'Aki Alat Berat', 'slug' => 'aki-alat-berat'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
