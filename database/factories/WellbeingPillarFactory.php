<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WellbeingPillar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WellbeingPillar>
 */
class WellbeingPillarFactory extends Factory
{
    protected $model = WellbeingPillar::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'is_active' => true,
            'order' => $this->faker->unique()->numberBetween(1, 10),
        ];
    }
}
