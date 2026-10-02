<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CatalogCacheTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_catalog_fetches_and_caches_categories_and_brands()
    {
        $category = Category::create(['name' => 'Cat1', 'slug' => 'cat-1', 'is_active' => true]);
        $brand = Brand::create(['name' => 'Brand1', 'slug' => 'brand-1']);
        Product::create([
            'name' => 'Product 1', 'slug' => 'product-1',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
        ]);

        // First request: Cache Miss
        DB::enableQueryLog();
        $response = $this->get('/produk');
        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee($brand->name);
        $queriesFirst = count(DB::getQueryLog());
        DB::flushQueryLog();

        // Ensure keys are in cache
        $this->assertTrue(Cache::has('catalog:categories'));
        $this->assertTrue(Cache::has('catalog:brands'));

        // Second request: Cache Hit
        $response2 = $this->get('/produk');
        $response2->assertStatus(200);
        $queriesSecond = count(DB::getQueryLog());

        // Second request should have fewer queries because categories & brands are cached
        $this->assertLessThan($queriesFirst, $queriesSecond);
    }

    public function test_catalog_category_filter_caches_brands_separately()
    {
        $category1 = Category::create(['name' => 'Cat1', 'slug' => 'cat-1', 'is_active' => true]);
        $category2 = Category::create(['name' => 'Cat2', 'slug' => 'cat-2', 'is_active' => true]);
        $brand = Brand::create(['name' => 'Brand1', 'slug' => 'brand-1']);

        Product::create([
            'name' => 'Product 1', 'slug' => 'product-1',
            'category_id' => $category1->id,
            'brand_id' => $brand->id,
            'is_active' => true,
        ]);

        $this->get('/produk/cat-1');

        $this->assertTrue(Cache::has("catalog:brands:category:{$category1->id}"));
        $this->assertFalse(Cache::has("catalog:brands:category:{$category2->id}"));

        // Mutating a product clears the cache
        $product2 = Product::create([
            'name' => 'Product 2', 'slug' => 'product-2',
            'category_id' => $category2->id,
            'brand_id' => $brand->id,
            'is_active' => true,
        ]);

        $this->assertFalse(Cache::has("catalog:brands:category:{$category2->id}"));
        $this->assertFalse(Cache::has("catalog:categories"));
    }

    public function test_cache_is_invalidated_on_product_mutation()
    {
        $category = Category::create(['name' => 'Cat1', 'slug' => 'cat-1', 'is_active' => true]);
        $product = Product::create([
            'name' => 'Product 1', 'slug' => 'product-1',
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $this->get('/produk');
        $this->assertTrue(Cache::has('catalog:categories'));

        // Update product
        $product->update(['name' => 'New Name']);
        $this->assertFalse(Cache::has('catalog:categories'));

        // Re-populate
        $this->get('/produk');
        $this->assertTrue(Cache::has('catalog:categories'));

        // Delete product
        $product->delete();
        $this->assertFalse(Cache::has('catalog:categories'));
    }

    public function test_cache_is_invalidated_on_category_mutation()
    {
        $category = Category::create(['name' => 'Cat1', 'slug' => 'cat-1', 'is_active' => true]);

        $this->get('/produk');
        $this->assertTrue(Cache::has('catalog:categories'));

        $category->update(['name' => 'New Cat Name']);
        $this->assertFalse(Cache::has('catalog:categories'));
    }

    public function test_cache_is_invalidated_on_brand_mutation()
    {
        $brand = Brand::create(['name' => 'Brand1', 'slug' => 'brand-1']);

        $this->get('/produk');
        $this->assertTrue(Cache::has('catalog:brands'));

        $brand->update(['name' => 'New Brand Name']);
        $this->assertFalse(Cache::has('catalog:brands'));
    }
}
