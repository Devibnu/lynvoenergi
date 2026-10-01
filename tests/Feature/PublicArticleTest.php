<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArticleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Need to set Settings or mock them if they are accessed by layouts, 
        // usually migrations seed or we use RefreshDatabase
        \App\Models\Setting::updateOrCreate(
            ['key' => 'seo_title'],
            ['value' => 'Lynvo Energi | Distributor Aki Industri Indonesia', 'label' => 'SEO Title']
        );
    }

    /**
     * D10-001: Published article appears in public listing.
     */
    public function test_published_article_appears_in_public_listing()
    {
        $article = Article::create([
            'title' => 'Cara Merawat Aki Genset',
            'slug' => 'cara-merawat-aki-genset',
            'content' => 'Ini adalah konten artikel',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('articles.index'));

        $response->assertStatus(200);
        $response->assertSee($article->title);
    }

    /**
     * D10-002: Published article detail returns HTTP 200.
     * D10-003: Published article renders correct title/content.
     */
    public function test_published_article_detail_returns_200_and_renders_correctly()
    {
        $article = Article::create([
            'title' => 'Panduan Baterai VRLA',
            'slug' => 'panduan-baterai-vrla',
            'content' => '<p>Konten detail panduan VRLA</p>',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('articles.show', $article->slug));

        $response->assertStatus(200);
        $response->assertSee('Panduan Baterai VRLA');
        $response->assertSee('Konten detail panduan VRLA', false);
    }

    /**
     * D10-004: Unpublished article does not appear publicly.
     */
    public function test_unpublished_article_does_not_appear_publicly()
    {
        $article = Article::create([
            'title' => 'Rahasia Internal Lynvo',
            'slug' => 'rahasia-internal-lynvo',
            'content' => 'Ini adalah konten rahasia',
            'is_active' => false,
        ]);

        $response = $this->get(route('articles.index'));

        $response->assertStatus(200);
        $response->assertDontSee($article->title);
    }

    /**
     * D10-005: Unpublished article detail is not publicly accessible.
     */
    public function test_unpublished_article_detail_is_not_accessible()
    {
        $article = Article::create([
            'title' => 'Rahasia Internal',
            'slug' => 'rahasia-internal',
            'content' => 'Konten',
            'is_active' => false,
        ]);

        $response = $this->get(route('articles.show', $article->slug));

        $response->assertStatus(404);
    }

    /**
     * D10-006: Invalid article slug returns HTTP 404.
     */
    public function test_invalid_article_slug_returns_404()
    {
        $response = $this->get(route('articles.show', 'slug-tidak-ada-12345'));

        $response->assertStatus(404);
    }

    /**
     * D10-007: Article metadata renders correctly.
     */
    public function test_article_metadata_renders_correctly()
    {
        $article = Article::create([
            'title' => 'Judul Artikel SEO',
            'slug' => 'judul-artikel-seo',
            'excerpt' => 'Ini adalah meta deskripsi khusus artikel.',
            'content' => 'Konten',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('articles.show', $article->slug));

        $response->assertStatus(200);
        // Expect exact strings based on the implementation
        $response->assertSee('<title>Judul Artikel SEO | Lynvo Energi</title>', false);
        $response->assertSee('Ini adalah meta deskripsi khusus artikel.');
    }

    /**
     * D10-008: Existing homepage remains accessible.
     */
    public function test_existing_homepage_remains_accessible()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    /**
     * D10-009: Existing product listing remains accessible.
     */
    public function test_existing_product_listing_remains_accessible()
    {
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
    }

    /**
     * D10-010: Existing RFQ remains accessible.
     */
    public function test_existing_rfq_remains_accessible()
    {
        $response = $this->get(route('quotation'));
        $response->assertStatus(200);
    }

    /**
     * D10-011: Existing contact remains accessible.
     */
    public function test_existing_contact_remains_accessible()
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
    }

    /**
     * D10-012: Existing Local SEO route remains accessible.
     */
    public function test_existing_local_seo_route_remains_accessible()
    {
        // Seeding required coverage area for local SEO
        \App\Models\CoverageArea::create([
            'city_name' => 'Serang',
            'slug' => 'toko-aki-serang',
            'is_active' => true,
            'hero_title' => 'Toko Aki Serang',
            'district_coverage' => 'Serang',
            'custom_intro_text' => 'Intro text',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Desc'
        ]);
        
        $response = $this->get(route('local.landing', 'toko-aki-serang'));
        $response->assertStatus(200);
    }
}
