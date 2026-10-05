<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalSeoLandingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed settings
        Setting::create(['key' => 'hero_phone', 'value' => '08123456789', 'label' => 'Hero Phone']);
        Setting::create(['key' => 'whatsapp_number', 'value' => '628123456789', 'label' => 'WA']);

        // Seed a coverage area
        CoverageArea::create([
            'city_name' => 'Test City',
            'slug' => 'toko-aki-test-city',
            'hero_title' => 'Toko Aki Test City',
            'district_coverage' => 'District 1, District 2',
            'custom_intro_text' => 'Intro text',
            'meta_title' => 'Meta Title Test City',
            'meta_description' => 'Meta Desc Test City',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        CoverageArea::create([
            'city_name' => 'Inactive City',
            'slug' => 'toko-aki-inactive',
            'hero_title' => 'Toko Aki Inactive',
            'district_coverage' => 'District 1',
            'custom_intro_text' => 'Intro text',
            'meta_title' => 'Meta Title Inactive',
            'meta_description' => 'Meta Desc Inactive',
            'is_active' => false,
            'sort_order' => 2,
        ]);
    }

    public function test_active_coverage_area_returns_200()
    {
        $response = $this->get('/toko-aki-test-city');
        $response->assertStatus(200);
    }

    public function test_inactive_coverage_area_returns_404()
    {
        $response = $this->get('/toko-aki-inactive');
        $response->assertStatus(404);
    }

    public function test_non_existent_coverage_area_returns_404()
    {
        $response = $this->get('/toko-aki-tidak-ada');
        $response->assertStatus(404);
    }

    public function test_page_renders_correct_seo_meta_tags()
    {
        $response = $this->get('/toko-aki-test-city');
        $response->assertStatus(200);

        $response->assertSee('<title>Meta Title Test City</title>', false);
        $response->assertSee('Meta Desc Test City', false);
    }

    public function test_serang_landing_uses_transactional_metadata_and_valid_heading_hierarchy()
    {
        CoverageArea::create([
            'city_name' => 'Serang',
            'slug' => 'toko-aki-serang',
            'hero_title' => 'Toko Aki Serang',
            'district_coverage' => 'Serang Kota',
            'custom_intro_text' => 'Layanan aki di Serang.',
            'meta_title' => 'Existing Serang Title',
            'meta_description' => 'Existing Serang Description',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $response = $this->get('/toko-aki-serang');
        $response->assertStatus(200);
        $response->assertSee(
            '<title>Toko Aki Serang | Jual, Ganti &amp; Pasang Aki di Tempat</title>',
            false
        );
        $response->assertSee(
            '<meta name="description" content="Jual aki Serang untuk mobil dan kendaraan Anda. Lynvo Energi melayani ganti, antar, pasang aki di tempat, dan tukar tambah aki dengan teknisi siap datang ke lokasi.">',
            false
        );
        $this->assertMatchesRegularExpression(
            '/<link rel="canonical" href="https?:\/\/[^"]+\/toko-aki-serang">/',
            $response->getContent()
        );
        $response->assertSee('Pesan Aki & Panggil Teknisi', false);
        $response->assertSee('wa.me', false);
        $response->assertSee('tel:08123456789', false);
        $response->assertSee('Pertanyaan Seputar Toko Aki Serang', false);
        $response->assertSee('Cek Nilai Tukar Tambah Aki', false);
        $response->assertSee(route('services.battery_delivery'), false);
        $response->assertSee(route('local.landing', 'toko-aki-test-city'), false);

        $this->assertDoesNotMatchRegularExpression('/\/merek\/null/', $response->getContent());
        $this->assertDoesNotMatchRegularExpression(
            '/<a\b[^>]*>(?:(?!<\/a>).)*<a\b/s',
            $response->getContent()
        );

        preg_match('/<main\b[^>]*>(.*?)<\/main>/s', $response->getContent(), $mainMatch);
        $this->assertNotEmpty($mainMatch, 'The page must render its main content landmark');
        preg_match_all('/<h([1-6])\b/i', $mainMatch[1], $headingMatches);
        $headingLevels = array_map('intval', $headingMatches[1]);

        $this->assertNotEmpty($headingLevels);
        $this->assertSame(1, $headingLevels[0]);
        $this->assertSame(1, count(array_filter($headingLevels, fn (int $level) => $level === 1)));

        for ($index = 1; $index < count($headingLevels); $index++) {
            $this->assertLessThanOrEqual(
                1,
                $headingLevels[$index] - $headingLevels[$index - 1],
                'Heading levels must not skip a level'
            );
        }
    }

    public function test_page_renders_correct_ctas()
    {
        $response = $this->get('/toko-aki-test-city');
        $response->assertStatus(200);

        // Assert WA link is rendered using Setting
        $response->assertSee('wa.me');
        // Assert WA CTA text
        $response->assertSee('Test City');
    }

    public function test_global_seo_fallback_when_no_section_defined()
    {
        // We can create a temporary route returning a view without @section('title')
        \Illuminate\Support\Facades\Route::get('/test-no-seo', function () {
            return \Illuminate\Support\Facades\Blade::render(
                '@extends("layouts.app") @section("content") <p>No SEO</p> @endsection'
            );
        });

        // Set specific global values for this test
        Setting::updateOrCreate(['key' => 'seo_title'], ['value' => 'Global Default Title', 'label' => 'SEO Title']);
        Setting::updateOrCreate(['key' => 'seo_description'], ['value' => 'Global Default Desc', 'label' => 'SEO Desc']);

        $response = $this->get('/test-no-seo');
        $response->assertStatus(200);
        $response->assertSee('<title>Global Default Title</title>', false);
        $response->assertSee('Global Default Desc', false);
    }

    public function test_homepage_remains_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_product_listing_remains_accessible()
    {
        $response = $this->get('/produk');
        $response->assertStatus(200);
    }

    public function test_rfq_page_remains_accessible()
    {
        $response = $this->get('/minta-penawaran');
        $response->assertStatus(200);
    }

    public function test_popular_product_internal_linking_and_cta()
    {
        // Seed category and brand
        $category = \App\Models\Category::create([
            'name' => 'Aki Mobil Test',
            'slug' => 'aki-mobil-test',
            'is_active' => true,
        ]);

        $brand = \App\Models\Brand::create([
            'name' => 'Test Brand',
            'slug' => 'test-brand',
            'is_active' => true,
        ]);

        // Seed popular product
        $product = \App\Models\Product::create([
            'name' => 'Aki Keren NS40Z',
            'slug' => 'aki-keren-ns40z',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
            'is_popular_retail' => true,
            'price' => 1000000,
            'voltage' => '12V',
            'capacity_ah' => 35,
        ]);

        $response = $this->get('/toko-aki-test-city');
        $response->assertStatus(200);

        $expectedProductUrl = route('products.show', [$category->slug, $product->slug]);

        // TEST 1 & 2 & 3: Local landing page menampilkan popular product dengan link menuju Product Detail
        $response->assertSee($expectedProductUrl);

        // Assert the anchor tag contains the product name
        // (Using assertSeeHtml since we just wrapped the h3 with a)
        $response->assertSee('<a href="' . $expectedProductUrl . '" class="block">', false);
        $response->assertSee('Aki Keren NS40Z', false);

        // TEST 4: WhatsApp CTA existing tetap tersedia
        $response->assertSee($product->whatsapp_order_url);
        $response->assertSee('Pesan & Pasang Aki Ini', false);
    }

    public function test_service_hub_popular_product_internal_linking()
    {
        // Seed category and brand
        $category = \App\Models\Category::create([
            'name' => 'Aki Motor Test',
            'slug' => 'aki-motor-test',
            'is_active' => true,
        ]);

        $brand = \App\Models\Brand::create([
            'name' => 'Test Brand 2',
            'slug' => 'test-brand-2',
            'is_active' => true,
        ]);

        // Seed popular product
        $product = \App\Models\Product::create([
            'name' => 'Aki Mantap',
            'slug' => 'aki-mantap',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
            'is_popular_retail' => true,
            'price' => 150000,
            'voltage' => '12V',
            'capacity_ah' => 5,
        ]);

        $response = $this->get(route('services.battery_delivery'));
        $response->assertStatus(200);

        $expectedProductUrl = route('products.show', [$category->slug, $product->slug]);

        // Assert internal link exists
        $response->assertSee($expectedProductUrl);
        $response->assertSee('<a href="' . $expectedProductUrl . '" class="block">', false);
        $response->assertSee('Aki Mantap', false);

        // Assert WhatsApp CTA existing
        $response->assertSee($product->whatsapp_order_url);
    }
}
