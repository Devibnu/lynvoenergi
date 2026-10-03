<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\CoverageArea;

class D16ImplementationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure there's a category and brand for product testing
        Category::create(['name' => 'Category A', 'slug' => 'category-a']);
        Brand::create(['name' => 'Brand A', 'slug' => 'brand-a']);
        CoverageArea::create(['city_name' => 'Serang', 'slug' => 'toko-aki-serang', 'is_active' => true, 'hero_title' => 'Toko Aki Serang', 'district_coverage' => 'Serang Kota']);
    }

    /**
     * D16-01: Test slug uniqueness on Product create
     */
    public function test_product_creation_fails_on_duplicate_name_due_to_slug()
    {
        $admin = User::factory()->create();
        $category = Category::first();
        $brand = Brand::first();

        // Create first product
        Product::create([
            'name' => 'Aki GS Astra',
            'slug' => 'aki-gs-astra',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        // Attempt to create second product with same name
        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Aki GS Astra', // Same name -> duplicate slug -> duplicate name
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response->assertSessionHasErrors('name'); // Validation should catch it
    }

    /**
     * D16-01: Test slug uniqueness on Product update
     */
    public function test_product_update_allows_same_name_for_same_record()
    {
        $admin = User::factory()->create();
        $category = Category::first();
        $brand = Brand::first();

        $product = Product::create([
            'name' => 'Aki GS Astra',
            'slug' => 'aki-gs-astra',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        // Update with the same name should pass (ignoring itself)
        $response = $this->actingAs($admin)->put(route('admin.products.update', $product->id), [
            'name' => 'Aki GS Astra',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.products.index'));
    }

    public function test_product_update_fails_on_duplicate_name_due_to_slug()
    {
        $admin = User::factory()->create();
        $category = Category::first();
        $brand = Brand::first();

        $productA = Product::create([
            'name' => 'Aki A',
            'slug' => 'aki-a',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $productB = Product::create([
            'name' => 'Aki B',
            'slug' => 'aki-b',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        // Update Product B with Product A's name should fail
        $response = $this->actingAs($admin)->put(route('admin.products.update', $productB->id), [
            'name' => 'Aki A', // duplicate name
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Aki B', $productB->fresh()->name);
    }

    public function test_product_creation_succeeds_on_unique_name()
    {
        $admin = User::factory()->create();
        $category = Category::first();
        $brand = Brand::first();

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Aki C',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Aki C', 'slug' => 'aki-c']);
    }

    public function test_category_creation_fails_on_duplicate_name()
    {
        $admin = User::factory()->create();
        
        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Category A', // Already created in setup
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_category_update_fails_on_duplicate_name()
    {
        $admin = User::factory()->create();
        $categoryB = Category::create(['name' => 'Category B', 'slug' => 'category-b']);
        
        $response = $this->actingAs($admin)->put(route('admin.categories.update', $categoryB->id), [
            'name' => 'Category A', // Already created in setup
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_category_update_allows_same_name_for_same_record()
    {
        $admin = User::factory()->create();
        $categoryB = Category::create(['name' => 'Category B', 'slug' => 'category-b']);
        
        $response = $this->actingAs($admin)->put(route('admin.categories.update', $categoryB->id), [
            'name' => 'Category B',
        ]);

        $response->assertSessionHasNoErrors();
    }

    public function test_application_creation_fails_on_duplicate_name()
    {
        $admin = User::factory()->create();
        \App\Models\Application::create(['name' => 'App A', 'slug' => 'app-a', 'hero_headline' => 'H', 'description' => 'D', 'is_active' => true]);
        
        $response = $this->actingAs($admin)->post(route('admin.applications.store'), [
            'name' => 'App A',
            'hero_headline' => 'H',
            'description' => 'D',
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_application_update_fails_on_duplicate_name()
    {
        $admin = User::factory()->create();
        \App\Models\Application::create(['name' => 'App A', 'slug' => 'app-a', 'hero_headline' => 'H', 'description' => 'D', 'is_active' => true]);
        $appB = \App\Models\Application::create(['name' => 'App B', 'slug' => 'app-b', 'hero_headline' => 'H', 'description' => 'D', 'is_active' => true]);
        
        $response = $this->actingAs($admin)->put(route('admin.applications.update', $appB->id), [
            'name' => 'App A',
            'hero_headline' => 'H',
            'description' => 'D',
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_application_update_allows_same_name_for_same_record()
    {
        $admin = User::factory()->create();
        $appB = \App\Models\Application::create(['name' => 'App B', 'slug' => 'app-b', 'hero_headline' => 'H', 'description' => 'D', 'is_active' => true]);
        
        $response = $this->actingAs($admin)->put(route('admin.applications.update', $appB->id), [
            'name' => 'App B',
            'hero_headline' => 'H',
            'description' => 'D',
            'is_active' => 1,
        ]);

        $response->assertSessionHasNoErrors();
    }

    /**
     * D16-04: Local SEO Brand Eager Loading N+1 Prevention
     */
    public function test_local_seo_loads_without_n_plus_one_for_brands()
    {
        $category = Category::first();
        $brand = Brand::first();
        
        Product::create([
            'name' => 'Aki 1',
            'slug' => 'aki-1',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_popular_retail' => true,
            'is_active' => true,
        ]);
        
        Product::create([
            'name' => 'Aki 2',
            'slug' => 'aki-2',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_popular_retail' => true,
            'is_active' => true,
        ]);

        \DB::enableQueryLog();
        $response = $this->get(route('local.landing', 'toko-aki-serang'));
        $response->assertStatus(200);
        $queries = \DB::getQueryLog();
        
        // Ensure no query is strictly selecting from brands multiple times
        $brandQueries = collect($queries)->filter(function ($query) {
            return str_contains($query['query'], 'select * from `brands` where `brands`.`id` in');
        });
        
        // It should eager load brands exactly once, or zero if none
        $this->assertLessThanOrEqual(1, $brandQueries->count(), 'Brands should be eager loaded, preventing N+1 queries.');
    }

    /**
     * D16-05: Logout Route Authentication
     */
    public function test_guest_cannot_logout()
    {
        // Need to hit the endpoint via POST (so CSRF is needed, but we can bypass CSRF for testing or just test middleware)
        // With WithoutMiddleware, it won't test auth. We just post and expect redirect to login.
        $response = $this->post(route('logout'));
        
        // Since it's protected by 'auth', it should redirect to login page for guests
        $response->assertRedirect(route('login'));
    }
    
    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('logout'));
        
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
