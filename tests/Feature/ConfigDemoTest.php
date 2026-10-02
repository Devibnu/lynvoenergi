<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;

class ConfigDemoTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_respects_demo_config()
    {
        Config::set('demo.enabled', true);
        
        $controller = new ResetController();
        $request = Request::create('/recover-password', 'POST', ['email' => 'test@example.com']);
        $response = $controller->sendEmail($request);
        
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('You are in a demo version, you can\'t recover your password.', session('errors')->first('msg2'));
    }
}
