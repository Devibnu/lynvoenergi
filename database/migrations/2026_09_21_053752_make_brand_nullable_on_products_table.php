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
            $table->string('brand')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // To safely restore NOT NULL, we must backfill any NULL values
        // with the official brand name via the brand_id relationship.
        DB::table('products')->whereNull('brand')->orderBy('id')->chunk(100, function ($products) {
            foreach ($products as $product) {
                $brand = DB::table('brands')->where('id', $product->brand_id)->first();
                if (!$brand) {
                    throw new \RuntimeException("Cannot safely rollback. Product ID {$product->id} has invalid or missing brand_id ({$product->brand_id}).");
                }
                DB::table('products')->where('id', $product->id)->update(['brand' => $brand->name]);
            }
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable(false)->change();
        });
    }
};
