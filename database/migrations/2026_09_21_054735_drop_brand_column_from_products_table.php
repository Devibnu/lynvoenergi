<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('brand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * NOTE: The historical legacy string values (e.g. "Massiv" for Product 6)
     * were irretrievably destroyed when the column was dropped. This rollback
     * will only restore the column structure as nullable, and backfill it with
     * the normalized official Brand name (e.g. "Yuasa") derived from brand_id.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable();
        });

        DB::table('products')->orderBy('id')->chunk(100, function ($products) {
            foreach ($products as $product) {
                if ($product->brand_id) {
                    $brand = DB::table('brands')->where('id', $product->brand_id)->first();
                    if ($brand) {
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update(['brand' => $brand->name]);
                    }
                }
            }
        });
    }
};
