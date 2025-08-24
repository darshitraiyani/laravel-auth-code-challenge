<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInvitation;
use App\Models\User;

class MagicLinkController extends Controller
{
    public function getUserByMagicLink(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(['message' => 'Invalid or expired link'], 422);
        }

        $request->validate(['token' => ['required','string']]);

        try {
            $token = $request->query('token');

            $invitation = UserInvitation::where('token', $token)
                ->where('status', 'pending')
                ->where('token_expires_at', '>', now())
                ->first();

            if (!$invitation) {
                return response()->json(['message' => 'Invalid or expired link'], 422);
            }


            $invitation->update(['status' => 'used','used_at' => now()]);

            //create user if not exists
            $user = User::firstOrCreate(
                ['email' => $invitation->email],
                [
                    'first_name' => $invitation->first_name, 
                    'last_name' => $invitation->last_name
                ]
            );

            // Create API token for passwordless login
            $authToken = $user->createToken('magic-link-login')->plainTextToken;

            if ($user) {
                $user->update([
                    'registration_step' => 'profile_info'
                ]);
            }

            return response()->json([
                'success' => true,
                'token' => $authToken,
                'message' => 'User fetched successfully.',
                'user' => [
                    'first_name' => $invitation->first_name,
                    'last_name'  => $invitation->last_name,
                    'email'      => $invitation->email,
                    'company_name' => $invitation->company_name
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user details using magic link.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
