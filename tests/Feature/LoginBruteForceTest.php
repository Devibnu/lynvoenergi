<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class LoginBruteForceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear rate limiter before tests
        RateLimiter::clear(Str::lower('test@example.com') . '|127.0.0.1');
    }

    public function test_valid_login_succeeds()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_login_returns_standard_error()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email atau password salah.']);
        $this->assertGuest();
    }

    public function test_login_throttles_after_five_failed_attempts()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 5 failed attempts
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
            $response->assertSessionHasErrors(['email' => 'Email atau password salah.']);
        }

        // 6th attempt should be throttled
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            'Terlalu banyak percobaan login',
            session('errors')->first('email')
        );
        $this->assertGuest();
    }

    public function test_throttle_is_isolated_by_ip_and_email()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 5 failed attempts for test@example.com from 127.0.0.1 (default)
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // Attempting with the same email but different IP should NOT be throttled
        $response = $this->withServerVariables(['REMOTE_ADDR' => '192.168.1.100'])->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors(['email' => 'Email atau password salah.']);

        // Attempting with a different email from the same IP should NOT be throttled
        $response = $this->post('/login', [
            'email' => 'other@example.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors(['email' => 'Email atau password salah.']);
    }

    public function test_successful_login_clears_throttle()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 4 failed attempts
        for ($i = 0; $i < 4; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // Successful login
        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        Auth::logout();

        // The counter should be reset, so the next 5 failed attempts will pass through as normal errors before throttling
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
            $response->assertSessionHasErrors(['email' => 'Email atau password salah.']);
        }
    }
}
