<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class InquiryThrottleTest extends TestCase
{
    use RefreshDatabase;

    protected function getValidPayload()
    {
        return [
            'type' => 'general_contact',
            'name' => 'Test User',
            'phone' => '081234567890',
            'message' => 'This is a test message.',
        ];
    }

    public function test_legitimate_inquiry_succeeds_and_creates_record()
    {
        $this->assertDatabaseCount('inquiries', 0);

        $response = $this->post('/inquiry', $this->getValidPayload());

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $response->assertSessionHas('wa_direct_url');

        $this->assertDatabaseCount('inquiries', 1);
        $this->assertDatabaseHas('inquiries', [
            'name' => 'Test User',
            'type' => 'general_contact',
        ]);
    }

    public function test_three_requests_are_allowed()
    {
        for ($i = 1; $i <= 3; $i++) {
            $response = $this->post('/inquiry', $this->getValidPayload());
            $response->assertStatus(302);
            $response->assertSessionHas('success');
        }

        $this->assertDatabaseCount('inquiries', 3);
    }

    public function test_fourth_request_is_throttled()
    {
        for ($i = 1; $i <= 3; $i++) {
            $this->post('/inquiry', $this->getValidPayload());
        }

        $response = $this->post('/inquiry', $this->getValidPayload());

        $response->assertStatus(429);
    }

    public function test_throttled_request_has_no_side_effect()
    {
        for ($i = 1; $i <= 3; $i++) {
            $this->post('/inquiry', $this->getValidPayload());
        }
        $this->assertDatabaseCount('inquiries', 3);

        // 4th request (Throttled)
        $this->post('/inquiry', $this->getValidPayload());

        $this->assertDatabaseCount('inquiries', 3); // count should not increase
    }

    public function test_throttle_isolation_between_ips()
    {
        // IP A makes 3 requests
        for ($i = 1; $i <= 3; $i++) {
            $this->withServerVariables(['REMOTE_ADDR' => '192.168.1.1'])
                 ->post('/inquiry', $this->getValidPayload());
        }

        // IP A 4th request is throttled
        $responseA = $this->withServerVariables(['REMOTE_ADDR' => '192.168.1.1'])
                          ->post('/inquiry', $this->getValidPayload());
        $responseA->assertStatus(429);

        // IP B makes a request, should be allowed
        $responseB = $this->withServerVariables(['REMOTE_ADDR' => '192.168.1.2'])
                          ->post('/inquiry', $this->getValidPayload());
        $responseB->assertStatus(302);

        $this->assertDatabaseCount('inquiries', 4);
    }


    public function test_invalid_request_consumes_throttle_quota()
    {
        // Make 3 invalid requests (missing fields)
        for ($i = 1; $i <= 3; $i++) {
            $response = $this->post('/inquiry', []);
            $response->assertStatus(302);
            $response->assertSessionHasErrors(['type', 'name', 'phone', 'message']);
        }

        // 4th request (even if valid) should be throttled
        $response = $this->post('/inquiry', $this->getValidPayload());
        $response->assertStatus(429);

        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_throttle_resets_after_decay()
    {
        // Make 3 requests
        for ($i = 1; $i <= 3; $i++) {
            $this->post('/inquiry', $this->getValidPayload());
        }

        // 4th is throttled
        $this->post('/inquiry', $this->getValidPayload())->assertStatus(429);

        // Travel 1 minute into the future
        $this->travel(1)->minutes();

        // Should be allowed again
        $response = $this->post('/inquiry', $this->getValidPayload());
        $response->assertStatus(302);

        $this->assertDatabaseCount('inquiries', 4);
    }
}
