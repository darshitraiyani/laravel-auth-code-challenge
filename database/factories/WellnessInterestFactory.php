<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WellnessInterest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WellnessInterest>
 */
class WellnessInterestFactory extends Factory
{
    protected $model = WellnessInterest::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                'Yoga', 'Meditation', 'Running', 'Strength Training',
                'Mindfulness', 'Journaling', 'Nutrition', 'Therapy',
                'Socializing', 'Volunteering', 'Music Therapy', 'Sleep Hygiene'
            ]),
            'category' => $this->faker->randomElement(['Physical', 'Mental', 'Emotional', 'Social']),
        ];
    }
}
