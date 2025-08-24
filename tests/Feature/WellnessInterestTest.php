<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WellnessInterest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WellnessInterestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_grouped_wellness_interests_by_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        WellnessInterest::factory()->create(['category' => 'Physical']);
        WellnessInterest::factory()->create(['category' => 'Mental']);
        WellnessInterest::factory()->create(['category' => 'Mental']);

        $response = $this->getJson('/api/wellness-interests');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Wellness interests retrieved successfully.',
                 ]);

        $data = $response->json('data');

        $categories = collect($data)->pluck('category')->unique()->toArray();
        $this->assertContains('Physical', $categories);
        $this->assertContains('Mental', $categories);
    }

    #[Test]
    public function it_stores_user_wellness_interests_and_updates_step()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $interests = WellnessInterest::factory()->count(3)->create();

        $response = $this->postJson('/api/wellness-interests', [
            'interest_ids' => $interests->pluck('id')->toArray()
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Wellness interests saved successfully.',
                 ])
                 ->assertJsonCount(3, 'data');

        foreach ($interests as $interest) {
            $this->assertDatabaseHas('user_wellness_interest', [
                'user_id' => $user->id,
                'wellness_interest_id' => $interest->id,
            ]);
        }

        $this->assertEquals('select_pillars', $user->fresh()->registration_step);
    }

    #[Test]
    public function it_validates_invalid_interest_ids()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/wellness-interests', [
            'interest_ids' => ['not-an-id', 999999]
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'interest_ids.0',
                     'interest_ids.1',
                 ]);
    }
}
