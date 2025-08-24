<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'first_name' => 'Demo',
            'last_name' => 'User',
            'email' => 'demo@example.com',
        ]);

        $this->call(
            [
                WellnessInterestsSeeder::class,
                WellbeingPillarsSeeder::class
            ]
        );
    }
}
