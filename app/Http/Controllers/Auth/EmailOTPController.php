<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInvitation;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

class EmailOTPController extends Controller
{
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
        ],[], $request->query());

        try {
            $invitation = UserInvitation::where('email', $request->query('email'))->first();

            if (!$invitation) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email ID has not been invited by your company admin. Please contact your admin for access.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully.',
                'user' => [
                    'first_name' => $invitation->first_name,
                    'last_name' => $invitation->last_name,
                    'email' => $invitation->email
                ]
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify email.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendOTP(Request $request)
    {
        $request->validate(['email' => ['required', 'email:rfc,dns']],[], $request->query());

        try {
            $invitation = UserInvitation::where('email', $request->query('email'))->first();
            if (!$invitation) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email ID has not been invited by your company admin. Please contact your admin for access.'
                ], 404);
            }

            $otp = rand(100000, 999999);

            UserOtp::create([
                'email' => $request->query('email'),
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(15),
            ]);

            Mail::to($request->query('email'))->send(new OTPMail($invitation,$otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP sent to email successfully.'
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send otp.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'otp' => ['required', 'digits:6'],
        ],[], $request->query());

        try {
            $invitation = UserInvitation::where('email', $request->query('email'))->first();
            if (!$invitation) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email ID has not been invited by your company admin. Please contact your admin for access.'
                ], 404);
            }

            $otpRecord = UserOtp::where('email', $request->query('email'))
                            ->whereNull('used_at')
                            ->where('expires_at', '>', now())
                            ->latest()
                            ->first();

            if (!$otpRecord || !Hash::check($request->query('otp'), $otpRecord->otp)) {
                return response()->json([
                    'message' => 'Invalid or expired OTP'
                ], 422);
            }

            $otpRecord->update(['used_at' => now()]);

            $user = User::firstOrCreate(
                ['email' => $invitation->email],
                [
                    'first_name' => $invitation->first_name, 
                    'last_name' => $invitation->last_name
                ]
            );

            // Create API token for passwordless login
            $authToken = $user->createToken('email-otp-login')->plainTextToken;

            if ($user) {
                $user->update([
                    'registration_step' => 'profile_info'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.',
                'token' => $authToken,
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
                'message' => 'Failed to verify otp.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
