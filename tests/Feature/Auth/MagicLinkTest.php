<?php

namespace Tests\Feature\Auth;

use App\Models\UserInvitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MagicLinkTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_fetches_user_successfully_with_valid_magic_link()
    {
        $invitation = UserInvitation::factory()->create([
            'status' => 'pending',
            'token' => 'valid-token',
            'token_expires_at' => now()->addDay(),
        ]);

        $url = URL::signedRoute('magic-link.user', [
            'token' => $invitation->token,
        ]);

        $response = $this->getJson($url);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User fetched successfully.',
                'user' => [
                    'email' => $invitation->email,
                    'first_name' => $invitation->first_name,
                    'last_name' => $invitation->last_name,
                ]
            ]);

        $this->assertDatabaseHas('user_invitations', [
            'email' => $invitation->email,
            'status' => 'used',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $invitation->email,
            'first_name' => $invitation->first_name,
        ]);
    }

    #[Test]
    public function it_fails_if_signed_url_is_invalid()
    {
        $invitation = UserInvitation::factory()->create([
            'status' => 'pending',
            'token' => 'some-token',
            'token_expires_at' => now()->addDay(),
        ]);

        $url = route('magic-link.user', ['token' => $invitation->token]); // not signed

        $response = $this->getJson($url);

        $response->assertStatus(422)
            ->assertJson(['message' => 'Invalid or expired link']);
    }

    #[Test]
    public function it_fails_if_invitation_is_expired()
    {
        $invitation = UserInvitation::factory()->create([
            'status' => 'pending',
            'token' => 'expired-token',
            'token_expires_at' => now()->subHour(),
        ]);

        $url = URL::signedRoute('magic-link.user', [
            'token' => $invitation->token,
        ]);

        $response = $this->getJson($url);

        $response->assertStatus(422)
            ->assertJson(['message' => 'Invalid or expired link']);
    }

    #[Test]
    public function it_fails_if_token_is_invalid()
    {
        $url = URL::signedRoute('magic-link.user', [
            'token' => 'nonexistent-token',
        ]);

        $response = $this->getJson($url);

        $response->assertStatus(422)
            ->assertJson(['message' => 'Invalid or expired link']);
    }

}
