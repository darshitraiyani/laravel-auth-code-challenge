<?php

namespace Tests\Feature\Auth;

use App\Mail\OTPMail;
use App\Models\User;
use App\Models\UserInvitation;
use App\Models\UserOtp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class EmailOTPTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure database is fresh for each test
        $this->artisan('migrate:fresh');
    }

    #[Test]
    public function it_validates_email_format_in_verify_email()
    {
        $response = $this->getJson('/api/verify-email?email=invalid-email');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

     #[Test]
    public function it_requires_email_parameter_in_send_otp()
    {
        $response = $this->getJson('/api/send-otp');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function it_validates_email_format_in_send_otp()
    {
        $response = $this->getJson('/api/send-otp?email=invalid-email');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function it_validates_email_and_otp_format_in_verify_otp()
    {
        $response = $this->getJson('/api/verify-otp?email=invalid-email&otp=12345');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'otp']);
    }

    #[Test]
    public function it_requires_email_parameter_in_verify_email()
    {
        $response = $this->getJson('/api/verify-email');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function it_requires_email_and_otp_parameters_in_verify_otp()
    {
        $response = $this->getJson('/api/verify-otp');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'otp']);
    }

    // Helper methods to create test data without factories
    private function createUserInvitation(array $data)
    {
        return UserInvitation::create(array_merge([
            'first_name' => 'Test',
            'last_name' => 'User',
            'company_name' => 'Test Company'
        ], $data));
    }

    private function createUserOtp(array $data)
    {
        return UserOtp::create(array_merge([
            'expires_at' => now()->addMinutes(15),
            'used_at' => null
        ], $data));
    }
}