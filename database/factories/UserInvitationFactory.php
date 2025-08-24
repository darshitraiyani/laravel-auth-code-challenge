<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserInvitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInvitation>
 */
class UserInvitationFactory extends Factory
{
    protected $model = UserInvitation::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'email'      => $this->faker->unique()->safeEmail,
            'token'      => bcrypt(Str::random(64)),
            'company_name' => 'Woliba',
            'status'     => 'pending',
            'token_expires_at' => now()->addHours(24),
        ];
    }

    /**
     * Expired token state.
     */
    public function expired()
    {
        return $this->state(fn () => [
            'token_expires_at' => now()->subDay(),
        ]);
    }

    /**
     * Used invitation state.
     */
    public function used()
    {
        return $this->state(fn () => [
            'status' => 'used',
            'used_at' => now(),
        ]);
    }
}
