<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WellbeingPillarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pillars = [
            [
                "name" => "Physical Wellbeing",
                "description" => "Energy, movement, sleep, and routine care",
                "order" => 1,
            ],
            [
                "name" => "Mental Wellbeing",
                "description" => "Clarity, focus and mindfulness",
                "order" => 2,
            ],
            [
                "name" => "Emotional Wellbeing",
                "description" => "Resilience, self-awareness and stress regulation",
                "order" => 3,
            ],
            [
                "name" => "Social Wellbeing",
                "description" => "Relationships and meaningful connections",
                "order" => 4,
            ],
            [
                "name" => "Intellectual Wellbeing",
                "description" => "Growth, creativity and learning",
                "order" => 5,
            ],
            [
                "name" => "Occupational Wellbeing",
                "description" => "Purpose, performance and work-life balance",
                "order" => 6,
            ],
            [
                "name" => "Spiritual Wellbeing",
                "description" => "Values, meaning and inner alignment",
                "order" => 7,
            ],
            [
                "name" => "Environmental Wellbeing",
                "description" => "Healthy, safe and productive surroundings",
                "order" => 8,
            ],
            [
                "name" => "Purpose & Contribution",
                "description" => "Giving back and living with meaning",
                "order" => 9,
            ],
            [
                "name" => "Longevity",
                "description" => "A sustainable, healthy lifestyle for the long term",
                "order" => 10,
            ],
            [
                "name" => "Nutritional Wellbeing",
                "description" => "Fueling your body and brain with intention",
                "order" => 11,
            ],
            [
                "name" => "Financial Wellbeing",
                "description" => "Security, budgeting and long-term stability",
                "order" => 12,
            ],
        ];

        foreach ($pillars as $pillar) {

            DB::table("wellbeing_pillars")->updateOrInsert(
                ["name" => $pillar["name"],"description" => $pillar["description"]],
                ["order" => $pillar["order"],"updated_at" => now(), "created_at" => now()]
            );
        }
    }
}
