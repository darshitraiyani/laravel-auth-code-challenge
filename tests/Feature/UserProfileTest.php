<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_saves_profile_successfully_with_valid_data()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $payload = [
            'password' => 'securePassword123',
            'password_confirmation' => 'securePassword123',
            'dob' => '08/24/2000',
            'contact_number' => '1234567890',
            'confirmation_flag' => true,
        ];

        $response = $this->postJson('/api/user/profile', $payload);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Profile saved successfully.',
                 ]);

        $user->refresh();

        $this->assertTrue(Hash::check('securePassword123', $user->password));
        $this->assertEquals('2000-08-24', $user->dob);
        $this->assertEquals('1234567890', $user->contact_number);
        $this->assertNotNull($user->confirmed_at);
        $this->assertTrue((bool)$user->profile_completed);
        $this->assertEquals('select_interests', $user->registration_step);
    }

    #[Test]
    public function it_returns_validation_error_for_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'password' => 'short',
            'password_confirmation' => 'nomatch',
            'dob' => 'invalid-date',
            'contact_number' => '',
            'confirmation_flag' => 'notaboolean',
        ];

        $response = $this->postJson('/api/user/profile', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'password',
                     'dob',
                     'contact_number',
                     'confirmation_flag',
                 ]);
    }
}
