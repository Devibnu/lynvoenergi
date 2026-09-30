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
}
