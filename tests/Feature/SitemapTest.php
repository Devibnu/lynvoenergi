<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\CoverageArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    /**
     * D11-SM-001 & D11-SM-002: Sitemap endpoint returns successful response and valid XML.
     */
    public function test_sitemap_returns_successful_response_and_valid_xml()
    {
        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $this->assertStringStartsWith('<?xml', $response->getContent());
    }

    /**
     * D11-SM-003: Existing sitemap URLs remain present.
     */
    public function test_existing_sitemap_urls_remain_present()
    {
        $area = CoverageArea::create([
            'city_name' => 'Cilegon',
            'slug' => 'toko-aki-cilegon',
            'is_active' => true,
            'hero_title' => 'Toko Aki Cilegon',
            'district_coverage' => 'Cilegon',
            'custom_intro_text' => 'Intro',
            'meta_title' => 'Meta',
            'meta_description' => 'Meta desc'
        ]);

        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertSee(route('home'));
        $response->assertSee(route('local.landing', $area->slug));
    }

    /**
     * D11-SM-004 & D11-SM-005 & D11-SM-007 & D11-SM-008: Published Article URL appears correctly, unique, and uses correct route.
     */
    public function test_published_articles_appear_in_sitemap()
    {
        $article1 = Article::create([
            'title' => 'Cara Merawat Aki',
            'slug' => 'cara-merawat-aki',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $article2 = Article::create([
            'title' => 'Panduan Genset',
            'slug' => 'panduan-genset',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertSee(route('articles.index'));
        $response->assertSee(route('articles.show', $article1->slug));
        $response->assertSee(route('articles.show', $article2->slug));
    }

    /**
     * D11-SM-006: Unpublished/draft Article does not appear.
     */
    public function test_unpublished_article_does_not_appear_in_sitemap()
    {
        $article = Article::create([
            'title' => 'Rahasia Internal',
            'slug' => 'rahasia-internal',
            'is_active' => false,
        ]);

        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertDontSee(route('articles.show', $article->slug));
    }

    /**
     * D13-07-01: Ensure Sitemap Controller uses LazyCollection to prevent memory exhaustion.
     */
    public function test_sitemap_uses_lazy_collection_for_memory_safety()
    {
        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);

        $view = $response->original;
        $this->assertInstanceOf(\Illuminate\View\View::class, $view);

        $data = $view->getData();

        $this->assertInstanceOf(\Illuminate\Support\LazyCollection::class, $data['coverageAreas']);
        $this->assertInstanceOf(\Illuminate\Support\LazyCollection::class, $data['categories']);
        $this->assertInstanceOf(\Illuminate\Support\LazyCollection::class, $data['products']);
        $this->assertInstanceOf(\Illuminate\Support\LazyCollection::class, $data['applications']);
        $this->assertInstanceOf(\Illuminate\Support\LazyCollection::class, $data['brands']);
        $this->assertInstanceOf(\Illuminate\Support\LazyCollection::class, $data['projects']);
        $this->assertInstanceOf(\Illuminate\Support\LazyCollection::class, $data['articles']);
    }

    /**
     * SEO Hardening: Ensure sitemap is stateless and public cacheable.
     */
    public function test_sitemap_is_stateless_and_cacheable()
    {
        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertHeaderMissing('Set-Cookie');
        $this->assertStringContainsString('max-age=3600', $response->headers->get('Cache-Control') ?? '');
        $this->assertStringContainsString('public', $response->headers->get('Cache-Control') ?? '');
        $this->assertStringNotContainsString('private', $response->headers->get('Cache-Control') ?? '');
    }
}
