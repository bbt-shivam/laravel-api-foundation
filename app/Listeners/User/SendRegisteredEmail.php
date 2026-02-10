<?php

namespace App\Listeners\User;

use App\Events\User\UserRegistered;
use App\Mail\User\UserRegisteredMail;
use App\Models\EmailVerificationToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendRegisteredEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(UserRegistered $event): void
    {
        $token = Str::random(64);
        
        EmailVerificationToken::create([
            'user_id' => $event->user->id,
            'token' => hash('sha256', $token),
            'expires_at' => now()->addMinutes(30),
        ]);

        Mail::to($event->user->email)->queue(new UserRegisteredMail($event->user, $token));
    }
}
