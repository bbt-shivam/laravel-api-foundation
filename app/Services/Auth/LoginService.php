<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function __construct()
    {}

    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->lock_until && now()->lessThan($user->lock_until)) {
            throw ValidationException::withMessages([
                'email' => ['Account locked. Try again later.'],
            ]);
        }

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->load('roles');

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
