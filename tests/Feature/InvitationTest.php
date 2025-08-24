<?php

namespace Tests\Feature;

use App\Models\UserInvitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_sends_invitation_and_creates_pending_user(): void
    {
        Mail::fake();

        $payload = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'john@test.com',
        ];

        $response = $this->postJson('/api/invite', $payload);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Invitation sent successfully. Please check your email.',
                 ]);

        $this->assertDatabaseHas('user_invitations', [
            'email' => 'john@test.com',
            'status' => 'pending',
        ]);
    }

    #[Test]
    public function it_updates_existing_invitation_instead_of_creating_duplicate(): void
    {
        Mail::fake();

        $payload = [
            'first_name' => 'Jane',
            'last_name'  => 'Doe',
            'email'      => 'jane@test.com',
        ];

        $response = $this->postJson('/api/invite', $payload);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertEquals(1, UserInvitation::where('email', 'jane@test.com')->count());
    }

    #[Test]
    public function it_fails_validation_for_invalid_email(): void
    {
        $payload = [
            'first_name' => 'Invalid',
            'last_name'  => 'User',
            'email'      => 'not-an-email',
        ];

        $response = $this->postJson('/api/invite', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function it_returns_server_error_if_mail_fails(): void
    {
        Mail::fake();

        Mail::shouldReceive('to->send')->andThrow(new \Exception('SMTP failed'));

        $payload = [
            'first_name' => 'Fail',
            'last_name'  => 'Case',
            'email'      => 'fail@test.com',
        ];

        $response = $this->postJson('/api/invite', $payload);

        $response->assertStatus(500)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Failed to invite user.',
                 ]);
    }
}
