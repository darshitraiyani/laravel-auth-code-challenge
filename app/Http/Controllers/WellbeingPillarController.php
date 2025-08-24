<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WellbeingPillar;

class WellbeingPillarController extends Controller
{
    public function index()
    {
        try {
            $pillars = WellbeingPillar::active()
                ->ordered()
                ->select('id', 'name', 'description', 'order')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Wellbeing pillars retrieved successfully.',
                'data' => $pillars
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wellbeing pillars.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request) {

        $request->validate([
            'pillar_ids' => 'required|array|size:3',
            'pillar_ids.*' => 'required|integer|exists:wellbeing_pillars,id'
        ], [
            'pillar_ids.size' => 'You must select exactly 3 wellbeing pillars.',
            'pillar_ids.*.exists' => 'One or more selected pillars are invalid.'
        ]);

        try {
            $user = $request->user();

            $wellbeingPillars = [];
            foreach ($request->pillar_ids as $index => $id) {
                $wellbeingPillars[$id] = [
                    'selection_order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $user->wellbeingPillars()->sync($wellbeingPillars);

            $user->update([
                'registration_step' => 'completed'
            ]);

            $userWellbeingPillars = $user->wellbeingPillars()
                                        ->withPivot('selection_order')
                                        ->select('wellbeing_pillars.id', 'wellbeing_pillars.name', 'wellbeing_pillars.description')
                                        ->orderBy('pivot_selection_order')
                                        ->get();

            $userWellbeingPillars = $userWellbeingPillars->map(function ($pillar) {
                                        return [
                                            'id' => $pillar->id,
                                            'name' => $pillar->name,
                                            'description' => $pillar->description,
                                            'selection_order' => $pillar->pivot->selection_order
                                        ];
                                    });

            return response()->json([
                'success' => true,
                'message' => 'Wellbeing pillars saved successfully.',
                'data' => $userWellbeingPillars
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save Wellbeing pillars.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
