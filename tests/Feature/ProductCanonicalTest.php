<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCanonicalTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_product_with_valid_category_returns_200()
    {
        $category = Category::create([
            'name' => 'Aki Mobil',
            'slug' => 'aki-mobil',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'GS Astra',
            'slug' => 'gs-astra',
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', ['category' => 'aki-mobil', 'product' => 'gs-astra']));
        $response->assertStatus(200);
    }

    public function test_valid_product_with_wrong_category_redirects_301_to_canonical()
    {
        $category = Category::create([
            'name' => 'Aki Mobil',
            'slug' => 'aki-mobil',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'GS Astra',
            'slug' => 'gs-astra',
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $wrongCategory = Category::create([
            'name' => 'Aki Motor',
            'slug' => 'aki-motor',
            'is_active' => true,
        ]);

        // Access product using wrong category slug
        $response = $this->get(route('products.show', ['category' => 'aki-motor', 'product' => 'gs-astra']));

        $response->assertStatus(301);
        $response->assertRedirect(route('products.show', ['category' => 'aki-mobil', 'product' => 'gs-astra']));
    }

    public function test_query_string_is_preserved_during_canonical_redirect()
    {
        $category = Category::create([
            'name' => 'Aki Mobil',
            'slug' => 'aki-mobil',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'GS Astra',
            'slug' => 'gs-astra',
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $wrongCategory = Category::create([
            'name' => 'Aki Motor',
            'slug' => 'aki-motor',
            'is_active' => true,
        ]);

        // Access product using wrong category slug but with query string
        $response = $this->get(route('products.show', ['category' => 'aki-motor', 'product' => 'gs-astra']) . '?utm_source=google');

        $response->assertStatus(301);
        $response->assertRedirect(route('products.show', ['category' => 'aki-mobil', 'product' => 'gs-astra']) . '?utm_source=google');
    }

    public function test_non_existing_product_returns_404()
    {
        $response = $this->get(route('products.show', ['category' => 'aki-mobil', 'product' => 'missing-product']));
        $response->assertStatus(404);
    }
}
