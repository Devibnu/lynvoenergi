<?php

namespace Tests\Feature;

use App\Models\CompanyLocation;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class D18CompanyLocationCacheTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear caches before each test
        Cache::flush();
        
        Setting::updateOrCreate(['key' => 'hero_phone'], ['value' => '08123456789', 'label' => 'Hero Phone']);
        Setting::updateOrCreate(['key' => 'office_address'], ['value' => 'Test Address', 'label' => 'Office Address']);
        Setting::updateOrCreate(['key' => 'company_name'], ['value' => 'Test Company', 'label' => 'Company Name']);
    }

    public function test_primary_location_uses_cache()
    {
        CompanyLocation::create([
            'name' => 'HQ',
            'is_primary' => true,
            'is_active' => true,
            'sort_order' => 1,
            'address' => 'Test Address',
            'city' => 'Test City'
        ]);

        DB::enableQueryLog();
        DB::flushQueryLog();

        $location1 = CompanyLocation::getPrimaryLocation();
        $queries1 = DB::getQueryLog();
        
        DB::flushQueryLog();
        $location2 = CompanyLocation::getPrimaryLocation();
        $queries2 = DB::getQueryLog();

        $this->assertNotNull($location1);
        $this->assertEquals('HQ', $location1->name);
        $this->assertEquals($location1->id, $location2->id);

        $this->assertGreaterThan(0, count($queries1), "First access should hit database.");
        $this->assertCount(0, $queries2, "Subsequent access must use cache.");
    }

    public function test_contact_locations_uses_cache()
    {
        CompanyLocation::create(['name' => 'HQ', 'is_primary' => true, 'is_active' => true, 'sort_order' => 1, 'address' => 'A', 'city' => 'B']);
        CompanyLocation::create(['name' => 'Branch', 'is_primary' => false, 'is_active' => true, 'sort_order' => 2, 'address' => 'A', 'city' => 'B']);

        DB::enableQueryLog();
        DB::flushQueryLog();

        $locations1 = CompanyLocation::getContactLocations();
        $queries1 = DB::getQueryLog();
        
        DB::flushQueryLog();
        $locations2 = CompanyLocation::getContactLocations();
        $queries2 = DB::getQueryLog();

        $this->assertCount(2, $locations1);
        $this->assertEquals(2, $locations2->count());

        $this->assertGreaterThan(0, count($queries1), "First access should hit database.");
        $this->assertCount(0, $queries2, "Subsequent access must use cache.");
    }

    public function test_cache_is_invalidated_on_create()
    {
        CompanyLocation::create(['name' => 'HQ', 'is_primary' => true, 'is_active' => true, 'sort_order' => 1, 'address' => 'A', 'city' => 'B']);
        
        // Cache it
        CompanyLocation::getContactLocations();
        
        $this->assertTrue(Cache::has('contact_locations'));
        
        // Create new
        CompanyLocation::create(['name' => 'Branch', 'is_primary' => false, 'is_active' => true, 'sort_order' => 2, 'address' => 'A', 'city' => 'B']);
        
        // Cache should be forgotten
        $this->assertFalse(Cache::has('contact_locations'));
        $this->assertFalse(Cache::has('global_primary_location'));
    }

    public function test_cache_is_invalidated_on_update()
    {
        $loc = CompanyLocation::create(['name' => 'HQ', 'is_primary' => true, 'is_active' => true, 'sort_order' => 1, 'address' => 'A', 'city' => 'B']);
        
        // Cache it
        CompanyLocation::getPrimaryLocation();
        CompanyLocation::getContactLocations();
        
        // Update
        $loc->update(['name' => 'Headquarters']);
        
        // Cache should be forgotten
        $this->assertFalse(Cache::has('contact_locations'));
        $this->assertFalse(Cache::has('global_primary_location'));
    }

    public function test_cache_is_invalidated_on_delete()
    {
        $loc = CompanyLocation::create(['name' => 'HQ', 'is_primary' => true, 'is_active' => true, 'sort_order' => 1, 'address' => 'A', 'city' => 'B']);
        
        // Cache it
        CompanyLocation::getPrimaryLocation();
        CompanyLocation::getContactLocations();
        
        // Delete
        $loc->delete();
        
        // Cache should be forgotten
        $this->assertFalse(Cache::has('contact_locations'));
        $this->assertFalse(Cache::has('global_primary_location'));
    }

    public function test_view_regression_homepage_and_contact()
    {
        CompanyLocation::create([
            'name' => 'Global HQ',
            'is_primary' => true,
            'is_active' => true,
            'sort_order' => 1,
            'address' => 'Test Address 123',
            'city' => 'Test City'
        ]);

        $response1 = $this->get('/');
        $response1->assertStatus(200);
        $response1->assertSee('Global HQ');

        $response2 = $this->get('/kontak');
        $response2->assertStatus(200);
        $response2->assertSee('Global HQ');
    }
}
