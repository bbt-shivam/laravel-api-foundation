<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Resources\V1\UserResource;
use App\Services\Auth\LoginService;
use App\Services\Auth\PasswordService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginService $loginService)
    {
       $result = $loginService->login($request->validated());

        return $this->success([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ], 'Login Successfull');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Successfully logged out');
    }

    public function logoutFromAllDevice(Request $request){
        $request->user()->tokens()->delete();

        return $this->success(null, 'Successfully logged out');
    }

    public function changePassword(ChangePasswordRequest $request, PasswordService $passwordService)
    {
        $passwordService->changePassword($request->user(), $request->password);
        
        return $this->success(null, 'Password changed successfully. Please login again.', 200);
    }
}
