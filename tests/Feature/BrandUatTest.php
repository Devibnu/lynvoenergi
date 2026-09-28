<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;

class BrandUatTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdminUser()
    {
        return User::firstOrCreate(
            ['email' => 'admin_test_uat@lynvo.test'],
            ['name' => 'Admin UAT', 'password' => bcrypt('password')]
        );
    }

    public function test_sidebar_verification()
    {
        $user = $this->getAdminUser();
        $response = $this->actingAs($user)->get('/admin');
        
        $response->assertStatus(200);
        $response->assertSee('Merek');
        $response->assertSee('admin/brands');
        echo "[PASS] Sidebar Verification\n";
    }

    public function test_create_brand()
    {
        $user = $this->getAdminUser();
        $response = $this->actingAs($user)->post('/admin/brands', [
            'name' => 'Test Brand UAT',
            'description' => 'Test Description',
        ]);
        
        $response->assertRedirect(route('admin.brands.index'));
        $this->assertDatabaseHas('brands', ['name' => 'Test Brand UAT']);
        echo "[PASS] Create Brand\n";
    }

    public function test_duplicate_name_and_slug()
    {
        $user = $this->getAdminUser();
        Brand::firstOrCreate(['name' => 'Duplicate Brand'], ['slug' => 'duplicate-brand']);
        
        $response = $this->actingAs($user)->post('/admin/brands', [
            'name' => 'Duplicate Brand',
        ]);
        
        $response->assertSessionHasErrors('name');
        echo "[PASS] Duplicate Name / Slug\n";
    }

    public function test_edit_brand()
    {
        $user = $this->getAdminUser();
        $brand = Brand::firstOrCreate(['name' => 'To Be Edited'], ['slug' => 'to-be-edited']);
        
        $response = $this->actingAs($user)->put("/admin/brands/{$brand->id}", [
            'name' => 'Edited Brand UAT',
        ]);
        
        $response->assertRedirect(route('admin.brands.index'));
        $this->assertDatabaseHas('brands', ['name' => 'Edited Brand UAT']);
        echo "[PASS] Edit Brand\n";
    }

    public function test_product_form_integration()
    {
        $user = $this->getAdminUser();
        $brand = Brand::firstOrCreate(['name' => 'Integration Brand UAT'], ['slug' => 'integration-brand-uat']);
        
        $response = $this->actingAs($user)->get('/admin/products/create');
        
        $response->assertStatus(200);
        $response->assertSee('Integration Brand UAT');
        echo "[PASS] Product Form Integration\n";
    }

    public function test_delete_used_brand()
    {
        $user = $this->getAdminUser();
        $brand = Brand::firstOrCreate(['name' => 'Used Brand'], ['slug' => 'used-brand']);
        $category = Category::firstOrCreate(['name' => 'Test Cat'], ['slug' => 'test-cat']);
        $product = Product::firstOrCreate(
            ['slug' => 'test-prod-123'],
            ['name' => 'Test', 'brand_id' => $brand->id, 'category_id' => $category->id]
        );
        
        $response = $this->actingAs($user)->delete("/admin/brands/{$brand->id}");
        
        $response->assertSessionHasErrors('error'); // The specific key we used
        $this->assertDatabaseHas('brands', ['id' => $brand->id]); // Must still exist
        
        // Cleanup for real DB
        $product->delete();
        $brand->delete();
        
        echo "[PASS] Delete Used Brand\n";
    }

    public function test_delete_unused_brand()
    {
        $user = $this->getAdminUser();
        $brand = Brand::create(['name' => 'Unused Brand', 'slug' => 'unused-brand']);
        
        $response = $this->actingAs($user)->delete("/admin/brands/{$brand->id}");
        
        $response->assertRedirect(route('admin.brands.index'));
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
        echo "[PASS] Delete Unused Brand\n";
    }
}
