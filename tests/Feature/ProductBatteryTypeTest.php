<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductBatteryTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Since admin routes might need auth, we will mock a user or just hit the db directly if testing validation.
        $this->user = \App\Models\User::factory()->create();
    }

    private function createBrand()
    {
        return \App\Models\Brand::create([
            'name' => 'Test Brand',
            'slug' => 'test-brand',
        ]);
    }

    private function createCategory()
    {
        return \App\Models\Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    public function test_product_can_be_created_with_valid_battery_type(): void
    {
        $brand = $this->createBrand();
        $category = $this->createCategory();

        $response = $this->actingAs($this->user)->post(route('admin.products.store'), [
            'name' => 'Test Product',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'battery_type' => 'MF Kering',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'battery_type' => 'MF Kering',
        ]);
    }

    public function test_product_can_be_updated_with_valid_battery_type(): void
    {
        $brand = $this->createBrand();
        $category = $this->createCategory();
        $product = \App\Models\Product::create([
            'name' => 'Old Product',
            'slug' => 'old-product',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'battery_type' => null,
        ]);

        $response = $this->actingAs($this->user)->put(route('admin.products.update', $product->id), [
            'name' => 'Test Product Updated',
            'brand_id' => $product->brand_id,
            'category_id' => $product->category_id,
            'battery_type' => 'VRLA',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'battery_type' => 'VRLA',
        ]);
    }

    public function test_value_outside_options_is_rejected(): void
    {
        $brand = $this->createBrand();
        $category = $this->createCategory();

        $response = $this->actingAs($this->user)->post(route('admin.products.store'), [
            'name' => 'Test Product Invalid',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'battery_type' => 'Lithium', // Invalid
        ]);

        $response->assertSessionHasErrors('battery_type');
    }

    public function test_battery_type_can_be_null(): void
    {
        $brand = $this->createBrand();
        $category = $this->createCategory();

        $response = $this->actingAs($this->user)->post(route('admin.products.store'), [
            'name' => 'Test Product Null',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'battery_type' => null,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product Null',
            'battery_type' => null,
        ]);
    }

    public function test_public_product_detail_shows_saved_battery_type(): void
    {
        $brand = $this->createBrand();
        $category = $this->createCategory();
        $product = \App\Models\Product::create([
            'name' => 'Show Product 1',
            'slug' => 'show-product-1',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'battery_type' => 'AGM',
        ]);

        $response = $this->get(route('products.show', [$product->category->slug ?? 'aki', $product->slug]));
        $response->assertSee('AGM');
    }

    public function test_public_product_detail_does_not_show_maintenance_free_when_null(): void
    {
        $brand = $this->createBrand();
        $category = $this->createCategory();
        $product = \App\Models\Product::create([
            'name' => 'Show Product 2',
            'slug' => 'show-product-2',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'battery_type' => null,
        ]);

        $response = $this->get(route('products.show', [$product->category->slug ?? 'aki', $product->slug]));
        $response->assertDontSee('Maintenance Free');
        $response->assertSee('-');
    }
}
