<?php

namespace App\Services\Auth;

use App\Events\User\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function __construct()
    {}

    public function register(array $validated): void 
    {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        $user->assignRole('user');

        event(new UserRegistered($user));

        return;
    }
}
