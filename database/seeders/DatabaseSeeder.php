<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ApplicationSeeder::class,
            CoverageAreaSeeder::class,
            ProductSeeder::class,
            ProjectSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
