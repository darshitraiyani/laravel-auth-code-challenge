<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInvitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitationMail;

class InvitationController extends Controller
{
    public function invite(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email:rfc,dns',
        ]);

        try {
            $plainToken  = Str::random(64);
            $hashedToken = Hash::make($plainToken);

            $invitation = UserInvitation::updateOrCreate(
                ['email' => $validated['email']], // unique email
                [
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'token' => $hashedToken,
                    'company_name' => "Woliba",
                    'status'     => 'pending',
                    'token_expires_at' =>  now()->addHours(24)
                ]
            );

            // Send magic link email
            Mail::to($invitation->email)->send(new UserInvitationMail($invitation));

            return response()->json([
                'success' => true,
                'message' => 'Invitation sent successfully. Please check your email.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to invite user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
