<?php

namespace App\Listeners;

use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogLoginAttempt
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
    public function handle(object $event): void
    {
        Log::info('event listened', [
            'event' => get_class($event),
        ]);

        $email = $event instanceof Failed
            ? ($event->credentials['email'] ?? null)
            : $event->user?->email;

        if (! $email) {
            return;
        }

        LoginAttempt::create([
            'email' => $email,
            'ip_address' => request()->ip(),
            'successful' => $event instanceof Login,
        ]);

        if ($event instanceof Failed && $email) {
            $this->handleLock($email);
        }

        if ($event instanceof Login) {
            $this->clearFailures($email);
        }
    }

    protected function clearFailures(string $email): void
    {
        LoginAttempt::where('email', $email)
            ->where('successful', false)
            ->delete();

        User::where('email', $email)
            ->update(['lock_until' => null]);
    }

    protected function handleLock(string $email): void
    {
        $failures = LoginAttempt::where('email', $email)
            ->where('successful', false)
            ->where('created_at', '>=', now()->subMinutes(15))
            ->count();

        if ($failures >= 5) {
            User::where('email', $email)->update(['lock_until' => now()->addMinutes(15)]);
        }
    }
}
