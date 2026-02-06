<?php

namespace App\Services\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->lock_until && now()->lessThan($user->lock_until)) {
            throw ValidationException::withMessages([
                'email' => ['Account locked due to maximum failed attempt. Try again later.'],
            ]);
        }

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
