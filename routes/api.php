<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\InvitationController;
use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Auth\EmailOTPController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WellnessInterestController;
use App\Http\Controllers\WellbeingPillarController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/invite', [InvitationController::class, 'invite'])->name('invite.user');
//Flow 1 - Magic Link
Route::get('/magic-link/user', [MagicLinkController::class, 'getUserByMagicLink'])->name('magic-link.user');

//Flow 2- Email + OTP
Route::get('/verify-email', [EmailOTPController::class, 'verifyEmail'])->name('verify.email');
Route::get('/send-otp', [EmailOTPController::class, 'sendOTP'])->name('send.otp');
Route::get('/verify-otp', [EmailOTPController::class, 'verifyOTP'])->name('verify.otp');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/profile', [UserProfileController::class, 'saveProfile'])->name('save.user.profile');
    Route::get('/wellness-interests', [WellnessInterestController::class, 'index'])->name('wellness-interests.index');
    Route::post('/wellness-interests', [WellnessInterestController::class, 'store'])->name('wellness-interests.store');
    Route::get('/wellbeing-pillars', [WellbeingPillarController::class, 'index'])->name('wellbeing-pillars.index');
    Route::post('/wellbeing-pillars', [WellbeingPillarController::class, 'store'])->name('wellbeing-pillars.store');
});