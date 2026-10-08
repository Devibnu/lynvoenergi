<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCtaTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_saved_with_cta()
    {
        $admin = User::factory()->create();
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Product with CTA',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'cta_label' => 'Beli Sekarang',
            'cta_url' => 'https://tokopedia.com/beli',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Product with CTA',
            'cta_label' => 'Beli Sekarang',
            'cta_url' => 'https://tokopedia.com/beli',
        ]);
    }

    public function test_product_can_be_saved_without_cta_and_db_is_null()
    {
        $admin = User::factory()->create();
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Product without CTA',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Product without CTA',
            'cta_label' => null,
            'cta_url' => null,
        ]);
    }

    public function test_product_with_cta_shows_button_on_frontend()
    {
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);
        
        $product = Product::create([
            'name' => 'Product with CTA Display',
            'slug' => 'product-cta',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'cta_label' => 'Beli Custom CTA',
            'cta_url' => 'https://link.test',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', ['category' => 'cat', 'product' => 'product-cta']));
        $response->assertStatus(200);

        $response->assertSee('Beli Custom CTA');
        $response->assertSee('https://link.test');
    }

    public function test_product_without_cta_does_not_show_button_on_frontend()
    {
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);
        
        $product = Product::create([
            'name' => 'Product No CTA',
            'slug' => 'product-no-cta',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'cta_label' => null,
            'cta_url' => null,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', ['category' => 'cat', 'product' => 'product-no-cta']));
        $response->assertStatus(200);

        // Ensure custom CTA is absent
        $response->assertDontSee('Beli Custom CTA');
        
        // Ensure old hardcoded buttons are also absent (as specified)
        $response->assertDontSee('Pesan &amp; Pasang via WhatsApp');
        $response->assertDontSee('Minta Penawaran B2B / PO');
    }

    public function test_existing_product_without_cta_fields_renders_without_error()
    {
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);
        
        // Simulating existing product that has nulls (by default)
        $product = Product::create([
            'name' => 'Existing Product',
            'slug' => 'existing-product',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', ['category' => 'cat', 'product' => 'existing-product']));
        $response->assertStatus(200);
        $response->assertSee('Existing Product');
    }
}
