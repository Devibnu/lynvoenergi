<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Setting;
use App\Models\Brand;
use App\Models\Project;
use App\Models\Application;
use App\Models\Product;
use App\Models\Category;
use App\Models\CoverageArea;

class SeoStructuredDataTest extends TestCase
{
    use RefreshDatabase;

    private function getJsonLdSchemas(string $htmlContent): array
    {
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $htmlContent, $matches);
        $schemas = [];

        foreach ($matches[1] as $json) {
            $data = json_decode($json, true);
            $this->assertIsArray($data, 'Every JSON-LD script must contain valid JSON');
            $schemas[] = $data;
        }

        return $schemas;
    }

    private function getBreadcrumbListSchema(string $htmlContent): array
    {
        $schemas = array_values(array_filter(
            $this->getJsonLdSchemas($htmlContent),
            fn (array $data) => ($data['@type'] ?? null) === 'BreadcrumbList'
        ));

        $this->assertCount(1, $schemas, 'There must be exactly one BreadcrumbList schema on the page');
        return $schemas[0];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Setting::updateOrCreate(
            ['key' => 'seo_title'],
            ['value' => 'Lynvo Energi', 'label' => 'SEO Title']
        );
    }

    public function test_homepage_has_global_organization_and_website_schema()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('"@type": "Organization"', false);
        $response->assertSee('"@type": "WebSite"', false);
        $response->assertSee('#organization', false);
        $response->assertSee('#website', false);
    }

    public function test_products_index_has_breadcrumb_schema()
    {
        $response = $this->get('/produk');

        $response->assertStatus(200);
        $schema = $this->getBreadcrumbListSchema($response->getContent());
        $this->assertEquals('Beranda', $schema['itemListElement'][0]['name']);
        $this->assertEquals('Katalog Produk', $schema['itemListElement'][1]['name']);
    }

    public function test_brands_show_has_breadcrumb_schema()
    {
        $brand = Brand::create([
            'name' => 'Test Brand',
            'slug' => 'test-brand',
            'is_active' => true,
        ]);

        $response = $this->get('/merek/' . $brand->slug);

        $response->assertStatus(200);
        $schema = $this->getBreadcrumbListSchema($response->getContent());
        $this->assertEquals('Daftar Merek', $schema['itemListElement'][1]['name']);
        $this->assertEquals('Test Brand', $schema['itemListElement'][2]['name']);
    }

    public function test_projects_show_has_breadcrumb_schema()
    {
        $project = Project::create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'is_published' => true,
        ]);

        $response = $this->get('/project/' . $project->slug);

        $response->assertStatus(200);
        $schema = $this->getBreadcrumbListSchema($response->getContent());
        $this->assertEquals('Portofolio Proyek', $schema['itemListElement'][1]['name']);
        $this->assertEquals('Test Project', $schema['itemListElement'][2]['name']);
    }

    public function test_applications_show_has_breadcrumb_schema()
    {
        $application = Application::create([
            'name' => 'Test Application',
            'slug' => 'test-application',
            'is_active' => true,
        ]);

        $response = $this->get('/aplikasi/' . $application->slug);

        $response->assertStatus(200);
        $schema = $this->getBreadcrumbListSchema($response->getContent());
        $this->assertEquals('Sektor Aplikasi', $schema['itemListElement'][1]['name']);
        $this->assertEquals('Test Application', $schema['itemListElement'][2]['name']);
    }

    public function test_local_landing_has_breadcrumb_schema()
    {
        $area = CoverageArea::create([
            'city_name' => 'Test City',
            'slug' => 'toko-aki-test-city',
            'hero_title' => 'Toko Aki Test City',
            'district_coverage' => 'District 1',
            'custom_intro_text' => 'Intro text',
            'meta_title' => 'Meta Title Test City',
            'meta_description' => 'Meta Desc',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get('/' . $area->slug);

        $response->assertStatus(200);
        $response->assertSeeHtml('application/ld+json');

        $schemas = $this->getJsonLdSchemas($response->getContent());
        $types = array_column($schemas, '@type');
        $this->assertContains('AutoRepair', $types);
        $this->assertContains('FAQPage', $types);
        $this->assertContains('BreadcrumbList', $types);

        $localBusinessSchemas = array_values(array_filter(
            $schemas,
            fn (array $data) => ($data['@type'] ?? null) === 'AutoRepair'
        ));
        $this->assertCount(1, $localBusinessSchemas);
        $localBusinessSchema = $localBusinessSchemas[0];
        $this->assertArrayHasKey('hasOfferCatalog', $localBusinessSchema);
        $this->assertSame(
            'Service',
            $localBusinessSchema['hasOfferCatalog']['itemListElement'][0]['itemOffered']['@type']
        );

        $jsonLd = json_encode($schemas);
        $this->assertStringNotContainsString('Aki Mobil & Truk Bergaransi Resmi', $jsonLd);
        $this->assertDoesNotMatchRegularExpression('/"@type"\s*:\s*"Product"/', $jsonLd);

        $schema = $this->getBreadcrumbListSchema($response->getContent());

        $this->assertEquals('https://schema.org', $schema['@context']);
        $this->assertEquals('Beranda', $schema['itemListElement'][0]['name']);

        $lastItem = end($schema['itemListElement']);
        $this->assertEquals('Test City', $lastItem['name']);
        $this->assertMatchesRegularExpression('/^https:\/\/[^\/]+\/toko-aki-test-city$/', $lastItem['item']);
    }

    public function test_products_show_has_breadcrumb_schema_with_category()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->get('/produk/' . $category->slug . '/' . $product->slug);

        $response->assertStatus(200);

        $schema = $this->getBreadcrumbListSchema($response->getContent());

        $this->assertEquals('https://schema.org', $schema['@context']);
        $this->assertEquals('Beranda', $schema['itemListElement'][0]['name']);
        $this->assertEquals('Katalog Produk', $schema['itemListElement'][1]['name']);
        $this->assertEquals('Test Category', $schema['itemListElement'][2]['name']);

        $lastItem = end($schema['itemListElement']);
        $this->assertEquals('Test Product', $lastItem['name']);
        $this->assertMatchesRegularExpression('/^https:\/\/[^\/]+\/produk\/test-category\/test-product$/', $lastItem['item']);
    }
}
