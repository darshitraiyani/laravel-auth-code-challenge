<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WellbeingPillar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WellbeingPillarTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_active_ordered_wellbeing_pillars()
    {
        $user = User::factory()->create();

        WellbeingPillar::factory()->count(5)->create(['is_active' => false]);
        $activePillars = WellbeingPillar::factory()->count(3)->sequence(
            ['order' => 2],
            ['order' => 1],
            ['order' => 3],
        )->create(['is_active' => true]);

        $response = $this->actingAs($user)->getJson('/api/wellbeing-pillars');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Wellbeing pillars retrieved successfully.',
                 ])
                 ->assertJsonCount(3, 'data');

        // Check if data is returned in correct order
        $responseIds = collect($response->json('data'))->pluck('id')->toArray();
        $expectedIds = $activePillars->sortBy('order')->pluck('id')->values()->toArray();
        $this->assertEquals($expectedIds, $responseIds);
    }

    #[Test]
    public function it_saves_selected_wellbeing_pillars_for_user()
    {
        $user = User::factory()->create();
        $pillars = WellbeingPillar::factory()->count(3)->create();

        $payload = ['pillar_ids' => $pillars->pluck('id')->toArray()];

        $response = $this->actingAs($user)
                         ->postJson('/api/wellbeing-pillars', $payload);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Wellbeing pillars saved successfully.',
                 ])
                 ->assertJsonCount(3, 'data');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'registration_step' => 'completed',
        ]);

        foreach ($pillars as $index => $pillar) {
            $this->assertDatabaseHas('user_wellbeing_pillar', [
                'user_id' => $user->id,
                'wellbeing_pillar_id' => $pillar->id,
                'selection_order' => $index + 1,
            ]);
        }
    }

    #[Test]
    public function it_validates_pillar_ids_when_saving()
    {
        $user = User::factory()->create();
        $invalidPayload = [
            'pillar_ids' => [1, 2]
        ];

        $response = $this->actingAs($user)
                         ->postJson('/api/wellbeing-pillars', $invalidPayload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['pillar_ids']);
    }
}
