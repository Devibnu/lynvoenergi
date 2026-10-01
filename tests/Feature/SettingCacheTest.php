<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SettingCacheTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_first_retrieval_gets_correct_value()
    {
        Setting::create(['key' => 'site_title', 'value' => 'Lynvo', 'label' => 'Title']);
        
        $this->assertEquals('Lynvo', Setting::getValue('site_title'));
    }

    public function test_repeated_retrieval_does_not_query_database()
    {
        Setting::create(['key' => 'hero_phone', 'value' => '123456', 'label' => 'Phone']);
        
        DB::enableQueryLog();
        DB::flushQueryLog();

        // First retrieval (hits cache closure)
        $value1 = Setting::getValue('hero_phone');
        $this->assertEquals('123456', $value1);
        $this->assertCount(1, DB::getQueryLog());

        DB::flushQueryLog();

        // Second retrieval (hits cache directly)
        $value2 = Setting::getValue('hero_phone');
        $this->assertEquals('123456', $value2);
        $this->assertCount(0, DB::getQueryLog());
    }

    public function test_different_keys_do_not_collide()
    {
        Setting::create(['key' => 'hero_phone', 'value' => '123456', 'label' => 'Phone']);
        Setting::create(['key' => 'site_email', 'value' => 'test@test.com', 'label' => 'Email']);
        
        $this->assertEquals('123456', Setting::getValue('hero_phone'));
        $this->assertEquals('test@test.com', Setting::getValue('site_email'));
    }

    public function test_mutation_invalidates_cache_and_fetches_fresh_data()
    {
        Setting::create(['key' => 'hero_phone', 'value' => 'old_phone', 'label' => 'Phone']);
        
        // Cache the value
        $this->assertEquals('old_phone', Setting::getValue('hero_phone'));

        // Mutate setting
        Setting::where('key', 'hero_phone')->first()->update(['value' => 'new_phone']);

        // Check if cache returns fresh value
        $this->assertEquals('new_phone', Setting::getValue('hero_phone'));
    }

    public function test_missing_setting_returns_default()
    {
        $this->assertNull(Setting::getValue('nonexistent_key'));
        $this->assertEquals('default_val', Setting::getValue('nonexistent_key', 'default_val'));
    }
}
