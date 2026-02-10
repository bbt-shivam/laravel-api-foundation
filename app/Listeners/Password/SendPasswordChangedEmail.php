<?php

namespace App\Listeners\Password;

use App\Events\Password\PasswordChanged;
use App\Mail\Auth\PasswordChangedMail;
use Illuminate\Support\Facades\Mail;

class SendPasswordChangedEmail
{

    public $tries = 3;
    public $backoff = 10;

    public function __construct()
    {}

    public function handle(PasswordChanged $event): void
    {
        Mail::to($event->user->email)->queue(new PasswordChangedMail($event->user));
    }
}
