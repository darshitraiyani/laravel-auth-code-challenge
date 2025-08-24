<?php

namespace App\Mail;

use App\Models\UserInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class UserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    public function __construct(UserInvitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function build()
    {
        $magicLink = URL::temporarySignedRoute(
            'magic-link.user',
            Carbon::parse($this->invitation->token_expires_at),
            ['token' => $this->invitation->token]
        );

        return $this->subject('You are invited to join Woliba')
            ->view('emails.invitation')
            ->with([
                'first_name' => $this->invitation->first_name,
                'url' => $magicLink,
            ]);
    }
}
