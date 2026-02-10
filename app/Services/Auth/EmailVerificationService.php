<?php

namespace App\Services\Auth;

use App\Mail\User\VerifyEmailMail;
use App\Models\EmailVerificationToken;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class EmailVerificationService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function verify(string $token): void
    {
        $hashed = hash('sha256', $token);

        $tokenData = EmailVerificationToken::where('token', $hashed)->first();

        if (!$tokenData) {
            throw ValidationException::withMessages([
                'token' => ['Invalid Verification link']
            ]);
        }

        if ($tokenData->user->email_verified_at) {
            $tokenData->delete();

            throw ValidationException::withMessages([
                'email' => ['Email already verified.'],
            ]);
        }

        if ($tokenData->expires_at->isPast()) {
            $tokenData->delete();

            throw ValidationException::withMessages([
                'token' => ['verification link has expired']
            ]);
        }

        $tokenData->user->update([
            'email_verified_at' => now()
        ]);

        $tokenData->update();
    }

    public function resendVerificationLink(User $user)
    {
        if ($user->email_verified_at) {
            throw ValidationException::withMessages([
                'email' => ['Email already verified.']
            ]);
        }

        EmailVerificationToken::where('user_id', $user->id)->delete();

        $token = Str::random(64);

        EmailVerificationToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $token),
            'expires_at' => now()->addMinutes(30),
        ]);

        Mail::to($user->email)
            ->queue(new VerifyEmailMail($user, $token));
    }
}
