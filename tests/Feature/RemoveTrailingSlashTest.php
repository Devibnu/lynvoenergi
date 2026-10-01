<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class RemoveTrailingSlashTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Define a dummy POST route for testing
        Route::post('/dummy-post', function () {
            return response('OK', 200);
        });
        
        // Define a dummy valid GET route
        Route::get('/dummy-get', function () {
            return response('OK', 200);
        });
    }

    public function test_trailing_slash_on_get_redirects_to_non_trailing()
    {
        $request = \Illuminate\Http\Request::create('/dummy-get/', 'GET', [], [], [], ['REQUEST_URI' => '/dummy-get/']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertStringEndsWith('/dummy-get', $response->headers->get('Location'));
    }

    public function test_trailing_slash_on_head_redirects_to_non_trailing()
    {
        $request = \Illuminate\Http\Request::create('/dummy-get/', 'HEAD', [], [], [], ['REQUEST_URI' => '/dummy-get/']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertStringEndsWith('/dummy-get', $response->headers->get('Location'));
    }

    public function test_non_trailing_slash_on_get_returns_200()
    {
        $request = \Illuminate\Http\Request::create('/dummy-get', 'GET', [], [], [], ['REQUEST_URI' => '/dummy-get']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_root_does_not_redirect()
    {
        $request = \Illuminate\Http\Request::create('/', 'GET', [], [], [], ['REQUEST_URI' => '/']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_query_string_is_preserved_during_redirect()
    {
        $request = \Illuminate\Http\Request::create('/dummy-get/', 'GET', ['page' => 2, 'sort' => 'desc'], [], [], ['REQUEST_URI' => '/dummy-get/?page=2&sort=desc']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertStringEndsWith('/dummy-get?page=2&sort=desc', $response->headers->get('Location'));
    }

    public function test_post_request_with_trailing_slash_is_not_redirected()
    {
        // Because the trailing slash redirect ignores POST, it will try to hit /dummy-post/
        // Since Laravel router matches /dummy-post/ to /dummy-post automatically for POST,
        // it returns 200. We just assert it does NOT return a 301.
        $response = $this->post('/dummy-post/');
        $this->assertNotEquals(301, $response->getStatusCode());
        
        // And ensure standard non-trailing POST works
        $response2 = $this->post('/dummy-post');
        $response2->assertStatus(200);
    }

    public function test_static_files_with_extensions_are_not_redirected()
    {
        // For static files, even if requested with trailing slash, no redirect should occur
        
        // .xml file
        $request = \Illuminate\Http\Request::create('/sitemap.xml/', 'GET', [], [], [], ['REQUEST_URI' => '/sitemap.xml/']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        $this->assertNotEquals(301, $response->getStatusCode());

        // .txt file
        $request = \Illuminate\Http\Request::create('/robots.txt/', 'GET', [], [], [], ['REQUEST_URI' => '/robots.txt/']);
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        $this->assertNotEquals(301, $response->getStatusCode());
        
        // .css file
        $request = \Illuminate\Http\Request::create('/css/app.css/', 'GET', [], [], [], ['REQUEST_URI' => '/css/app.css/']);
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        $this->assertNotEquals(301, $response->getStatusCode());
    }

    public function test_storage_path_is_not_redirected()
    {
        $request = \Illuminate\Http\Request::create('/storage/images/test.jpg/', 'GET', [], [], [], ['REQUEST_URI' => '/storage/images/test.jpg/']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('OK', 200); });
        $this->assertNotEquals(301, $response->getStatusCode());
    }

    public function test_invalid_route_with_trailing_slash_is_not_redirected()
    {
        // A route that does not exist should not redirect to its non-trailing version.
        // It should just let the request through (resulting in 404 later).
        $request = \Illuminate\Http\Request::create('/route-yang-tidak-ada/', 'GET', [], [], [], ['REQUEST_URI' => '/route-yang-tidak-ada/']);
        $middleware = new \App\Http\Middleware\RemoveTrailingSlash();
        $response = $middleware->handle($request, function () { return response('CONTINUE', 200); });
        $this->assertNotEquals(301, $response->getStatusCode());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('CONTINUE', $response->getContent());
    }

    public function test_invalid_route_with_trailing_slash_returns_404_in_full_stack()
    {
        // To test the full stack without Laravel stripping the trailing slash in the test helper,
        // we can dispatch a raw Symfony request to the Http Kernel.
        $request = \Illuminate\Http\Request::create('/route-yang-tidak-ada/', 'GET', [], [], [], ['REQUEST_URI' => '/route-yang-tidak-ada/']);
        $response = $this->app->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_valid_route_with_trailing_slash_returns_301_in_full_stack()
    {
        // Ensure a valid route really does redirect via the full pipeline
        $request = \Illuminate\Http\Request::create('/dummy-get/', 'GET', [], [], [], ['REQUEST_URI' => '/dummy-get/']);
        $response = $this->app->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);

        $this->assertEquals(301, $response->getStatusCode());
        $this->assertStringEndsWith('/dummy-get', $response->headers->get('Location'));
    }
}
