<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if(! $user || !Hash::check($request->password, $user->password)){
            return $this->error(
                'The provided credentials are incorrect.',
                401
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token
        ], 'Login Successfull');
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return $this->success(null, 'Successfully logged out');
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $user->tokens()->delete();

        return $this->success(null, "Password changed successfully. Please login again.", 200);
    }
}
