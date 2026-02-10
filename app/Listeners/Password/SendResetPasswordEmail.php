<?php

namespace App\Listeners\Password;

use App\Events\Password\ForgotPassword;
use App\Mail\Auth\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class SendResetPasswordEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ForgotPassword $event): void
    {
        Mail::to($event->user->email)->queue(new ResetPasswordMail($event->user, $event->token));
    }
}
