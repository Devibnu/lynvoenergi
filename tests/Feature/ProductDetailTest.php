<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    private function getProductSchema(string $htmlContent): array
    {
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $htmlContent, $matches);

        foreach ($matches[1] as $json) {
            $data = json_decode($json, true);
            $this->assertIsArray($data, 'Every JSON-LD script must contain valid JSON');

            if (($data['@type'] ?? null) === 'Product') {
                return $data;
            }
        }

        $this->fail('The product detail page must contain a Product JSON-LD schema');
    }

    public function test_product_detail_shows_brand_link_if_brand_exists()
    {
        $category = Category::create([
            'name' => 'Aki Mobil',
            'slug' => 'aki-mobil',
            'is_active' => true,
        ]);

        $brand = Brand::create([
            'name' => 'GS Astra Test',
            'slug' => 'gs-astra-test',
        ]);

        $product = Product::create([
            'name' => 'Produk Test GS',
            'slug' => 'produk-test-gs',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', ['category' => 'aki-mobil', 'product' => 'produk-test-gs']));
        $response->assertStatus(200);

        // Assert it has a link to the brand
        $brandUrl = route('brands.show', $brand->slug);
        $response->assertSeeHtml('href="' . $brandUrl . '"');
        $response->assertSeeHtml('GS Astra Test');
        
        // Assert Schema/JSON-LD is present (SEO regression)
        $response->assertSeeHtml('application/ld+json');
        $schema = $this->getProductSchema($response->getContent());
        $this->assertSame('Produk Test GS', $schema['name']);
        $this->assertArrayHasKey('offers', $schema);
        $this->assertSame('GS Astra Test', $schema['brand']['name']);
        $this->assertSame('Aki Mobil', $schema['category']);
    }

    public function test_product_detail_renders_without_brand_link_if_brand_missing()
    {
        $category = Category::create([
            'name' => 'Aki Mobil',
            'slug' => 'aki-mobil',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Produk Tanpa Brand',
            'slug' => 'produk-tanpa-brand',
            'category_id' => $category->id,
            'brand_id' => null,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', ['category' => 'aki-mobil', 'product' => 'produk-tanpa-brand']));
        $response->assertStatus(200);

        // Assert no brand URL is rendered
        $response->assertDontSee('/merek/');
    }
}
