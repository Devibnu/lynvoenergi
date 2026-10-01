<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_is_available()
    {
        $response = $this->get('/tentang-kami');
        $response->assertOk();
    }

    public function test_contact_page_is_available()
    {
        $response = $this->get('/kontak');
        $response->assertOk();
    }
}
