<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserInvitation;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;
    public $otp;

    public function __construct(UserInvitation $invitation, string $otp)
    {
        $this->invitation = $invitation;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your OTP Code')
            ->view('emails.otp')
            ->with([
                'first_name' => $this->invitation->first_name,
                'otp' => $this->otp,
            ]);
    }
}
