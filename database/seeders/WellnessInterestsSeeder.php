<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WellnessInterestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Individual Sports" => [
                "Aerobics",
                "Yoga",
                "Running",
                "Cycling",
                "Hiking",
                "Tennis",
            ],
            "Ball Sports" => [
                "Football",
                "Basketball",
                "Volleyball",
                "Cricket",
                "Baseball",
                "Rugby",
            ],
            "Wheel Sports" => [
                "Skateboarding",
                "Rollerblading",
                "BMX",
                "Mountain Biking",
                "Scootering",
            ],
            "Combat Sports" => [
                "Boxing",
                "Kickboxing",
                "Mixed Martial Arts (MMA)",
                "Wrestling",
                "Judo",
                "Karate",
                "Taekwondo",
                "Muay Thai",
            ],
            "Resistance Training" => [
                "Weightlifting",
                "Bodybuilding",
                "CrossFit",
                "Powerlifting",
                "Functional Training",
                "Resistance Band Workouts",
                "Calisthenics",
            ],
            "Winter Sports" => [
                "Skiing (Alpine / Cross-country)",
                "Snowboarding",
                "Ice Skating",
                "Ice Hockey",
                "Curling",
                "Snowshoeing",
                "Sledding",
            ],
            "Water Sports" => [
                "Swimming",
                "Surfing",
                "Diving (Scuba / Free Diving)",
                "Snorkeling",
                "Kayaking",
                "Canoeing",
                "Rowing",
                "Sailing",
                "Stand-up Paddleboarding",
                "Water Polo",
            ],
            "Other Sports" => [
                "Archery",
                "Rock Climbing",
                "Horseback Riding (Equestrian)",
                "Golf",
                "Frisbee / Disc Golf",
                "Orienteering",
                "Parkour",
                "Adventure Racing",
            ],
            "Wellness" => [
                "Meditation",
                "Nutrition",
                "Mindfulness",
                "Pilates",
                "Breathwork",
            ],
        ];

        foreach ($categories as $category => $interests) {
            foreach ($interests as $interest) {

                DB::table("wellness_interests")->updateOrInsert(
                    ['category' => $category, 'name' => $interest],
                    ['updated_at' => now(), 'created_at' => now()]
                );

            }
        }
    }
}
