<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoStructuredDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_has_global_organization_and_website_schema()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('"@type": "Organization"', false);
        $response->assertSee('"@type": "WebSite"', false);
        $response->assertSee('#organization', false);
        $response->assertSee('#website', false);
    }
}
