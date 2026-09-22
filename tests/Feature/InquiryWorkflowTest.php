<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InquiryWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_quotation_form_is_available(): void
    {
        $this->get('/minta-penawaran')->assertOk();
    }

    public function test_valid_inquiry_is_persisted_with_category_and_encoded_whatsapp_message(): void
    {
        $category = Category::create([
            'name' => 'Aki Industri',
            'slug' => 'aki-industri',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->post('/inquiry', $this->inquiryPayload([
            'category_id' => $category->id,
            'source_url' => 'https://example.com/rfq',
            'message' => 'Butuh aki 12V & 100Ah.',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('wa_direct_url', fn ($url) => str_contains($url, '12V%20%26%20100Ah'));
        $this->assertDatabaseHas('inquiries', [
            'phone' => '0812-3456-7890',
            'category_id' => $category->id,
            'source_url' => 'https://example.com/rfq',
        ]);
    }

    public function test_invalid_required_fields_and_unsafe_source_url_are_rejected(): void
    {
        $response = $this->from('/minta-penawaran')->post('/inquiry', $this->inquiryPayload([
            'name' => '',
            'message' => '',
            'source_url' => 'javascript:alert(1)',
        ]));

        $response->assertRedirect('/minta-penawaran')->assertSessionHasErrors(['name', 'message', 'source_url']);
        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_http_and_https_source_urls_are_accepted(): void
    {
        foreach (['http://example.com/source', 'https://example.com/source'] as $sourceUrl) {
            $this->post('/inquiry', $this->inquiryPayload([
                'source_url' => $sourceUrl,
            ]))->assertRedirect()->assertSessionHasNoErrors();
        }

        $this->assertDatabaseCount('inquiries', 2);
    }

    public function test_malformed_phone_is_rejected(): void
    {
        $response = $this->from('/minta-penawaran')->post('/inquiry', $this->inquiryPayload([
            'phone' => '---',
        ]));

        $response->assertRedirect('/minta-penawaran')->assertSessionHasErrors('phone');
        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_reasonable_international_phone_number_is_preserved(): void
    {
        $this->post('/inquiry', $this->inquiryPayload([
            'phone' => '+1 (202) 555-0123',
        ]))->assertRedirect()->assertSessionHasNoErrors();

        $this->assertDatabaseHas('inquiries', ['phone' => '+1 (202) 555-0123']);
    }

    public function test_representative_indonesian_phone_formats_are_accepted(): void
    {
        foreach (['0812-3456-7890', '081234567890', '+62 812-3456-7890'] as $phone) {
            $this->post('/inquiry', $this->inquiryPayload([
                'phone' => $phone,
            ]))->assertRedirect()->assertSessionHasNoErrors();
        }

        $this->assertDatabaseCount('inquiries', 3);
    }

    public function test_inquiry_endpoint_is_limited_to_five_requests_per_ip_per_minute(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/inquiry', $this->inquiryPayload())->assertRedirect();
        }

        $this->post('/inquiry', $this->inquiryPayload())->assertStatus(429);
    }

    public function test_inquiry_is_available_again_after_the_rate_limit_window(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/inquiry', $this->inquiryPayload())->assertRedirect();
        }

        $this->travel(61)->seconds();

        $this->post('/inquiry', $this->inquiryPayload())->assertRedirect();
    }

    public function test_authenticated_user_can_view_inquiry_and_source_link_is_safe(): void
    {
        $inquiry = Inquiry::create($this->inquiryPayload([
            'source_url' => 'https://example.com/source',
        ]));

        $this->actingAs($this->adminUser())
            ->get(route('admin.inquiries.show', $inquiry))
            ->assertOk()
            ->assertSee('target="_blank" rel="noopener noreferrer"', false);
    }

    public function test_unauthenticated_user_cannot_view_admin_inquiries(): void
    {
        $this->get(route('admin.inquiries.index'))
            ->assertRedirect(route('login'));
    }

    public function test_legacy_unsafe_source_url_is_not_rendered_as_a_link(): void
    {
        $inquiry = Inquiry::create($this->inquiryPayload([
            'source_url' => 'javascript:alert(1)',
        ]));

        $this->actingAs($this->adminUser())
            ->get(route('admin.inquiries.show', $inquiry))
            ->assertOk()
            ->assertDontSee('href="javascript:alert(1)"', false);
    }

    public function test_inquiry_delete_remains_a_hard_delete(): void
    {
        $inquiry = Inquiry::create($this->inquiryPayload());

        $this->actingAs($this->adminUser())
            ->delete(route('admin.inquiries.destroy', $inquiry))
            ->assertRedirect(route('admin.inquiries.index'));

        $this->assertDatabaseMissing('inquiries', ['id' => $inquiry->id]);
    }

    private function inquiryPayload(array $overrides = []): array
    {
        return array_merge([
            'type' => 'b2b_quotation',
            'name' => 'Test Contact',
            'company_name' => 'PT Test Company',
            'phone' => '0812-3456-7890',
            'email' => 'contact@example.com',
            'target_location' => 'Serang',
            'quantity' => '2 unit',
            'message' => 'Need a battery quotation.',
        ], $overrides);
    }

    private function adminUser(): User
    {
        return User::create([
            'name' => 'Admin Test',
            'email' => 'admin-test@example.com',
            'password' => Hash::make('secret'),
        ]);
    }
}