<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WellnessInterest;

class WellnessInterestController extends Controller
{
    public function index()
    {
        try {
            $interests = [];

            $categories = WellnessInterest::select('id','category','name')->get()->groupBy('category')->toArray();

            if (isset($categories)) {
                foreach ($categories as $key => $value) {
                    $interests[] =[
                        "category" => $key,
                        "interests" => $value
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Wellness interests retrieved successfully.',
                'data' => $interests
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wellness interests.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'interest_ids' => ['required', 'array'],
            'interest_ids.*' => ['integer', 'exists:wellness_interests,id'],
        ]);

        try {
            $user = $request->user();

            $syncData = [];

            foreach ($request->interest_ids as $interestId) {
                $syncData[$interestId] = [
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $user->wellnessInterests()->sync($syncData);

            $user->update([
                'registration_step' => 'select_pillars'
            ]);

            $userWellnessInterests = $user->wellnessInterests()
                                        ->select('wellness_interests.id', 'wellness_interests.name', 'wellness_interests.category')
                                        ->get()
                                        ->each->makeHidden(['pivot']);

            return response()->json([
                'success' => true,
                'message' => 'Wellness interests saved successfully.',
                'data' => $userWellnessInterests,
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save wellness interests.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
