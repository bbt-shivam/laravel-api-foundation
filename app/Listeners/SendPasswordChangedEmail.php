<?php

namespace App\Listeners;

use App\Events\PasswordChanged;
use App\Mail\PasswordChangedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
