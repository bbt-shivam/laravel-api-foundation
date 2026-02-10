<?php

namespace App\Services\Auth;

use App\Events\Password\ForgotPassword;
use App\Events\Password\PasswordChanged;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function changePassword(User $user, string $new_password): void
    {
        $user->update([
            'password' => Hash::make($new_password),
        ]);
        event(new PasswordChanged($user));  

        $user->tokens()->delete();
        if ($user->must_change_password) {
            $user->must_change_password = false;
            $user->save();
        }
    }

    public function sendResetLink(string $email): void 
    {
        $user = User::where('email',$email)->first();
        if(!$user) return;

        PasswordReset::where('email', $email)->delete();

        $plainToken = Str::random(64);

        PasswordReset::create([
            'email' => $email,
            'token' => hash('sha256', $plainToken),
            'created_at' => now(),
        ]);

        event(new ForgotPassword($user, $plainToken));
    }

    public function resetPassword(string $token, string $password): void
    {
        $hashed = hash('sha256', $token);

        $tokenData = PasswordReset::where('token',$hashed)->first();

        if (! $tokenData) {
            throw ValidationException::withMessages([
                'token' => ['Invalid or expired reset link.'],
            ]);
        }

        if ($tokenData->created_at->addMinutes(10)->isPast()) {
            $tokenData->delete();

            throw ValidationException::withMessages([
                'token' => ['Reset link has expired.'],
            ]);
        }

        $user = User::where('email', $tokenData->email)->firstOrFail();

        if(Hash::check($password, $user->password)){
            throw ValidationException::withMessages(['password' => 'New password must be different from Old password']);
        }

        $user->update([
            'password' => Hash::make($password)
        ]);

        PasswordReset::where('email', $tokenData->email)->delete();

    }

    
}
