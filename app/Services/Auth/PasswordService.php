<?php

namespace App\Services\Auth;

use App\Events\PasswordChanged;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function changePassword(User $user, string $new_password){
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

    
}
