<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserProfileController extends Controller
{
    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed', // password_confirmation must be present
            'dob' => 'required|date_format:m/d/Y|before:today',
            'contact_number' => 'required|string|max:20',
            'confirmation_flag' => 'required|boolean',
        ]);

        try {
            $user = $request->user();

            $updateData = [
                'password' => Hash::make($validated['password']),
                'dob' => Carbon::parse($validated['dob'])->format("Y-m-d"),
                'contact_number' => $validated['contact_number'],
                'profile_completed' => true,
            ];

            if ($validated['confirmation_flag']) {
                $updateData['confirmed_at'] = now();
            }
            $updateData['registration_step'] = "select_interests";

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Profile saved successfully.',
                'user' => $user->only(['first_name', 'last_name', 'email', 'dob', 'contact_number']),
            ],200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save user profile.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
