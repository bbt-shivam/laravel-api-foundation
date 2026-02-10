<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\V1\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use App\Http\Resources\V1\UserResource;
use App\Services\Auth\LoginService;
use App\Services\Auth\PasswordService;
use App\Services\Auth\RegisterService;
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

    public function forgetPassword(ForgetPasswordRequest $request, PasswordService $passwordService){
        $passwordService->sendResetLink($request->email);
        return $this->success(null, 'Reset password link sent to the registered email!');
    }

    public function resetPassword(ResetPasswordRequest $request, PasswordService $passwordService){
        $passwordService->resetPassword($request->validated('token'), $request->validated('password'));
        return $this->success(null, 'Password reset successfully.');
    }

    public function register(RegisterRequest $request, RegisterService $registerService){
        $registerService->register($request->validated());
        return $this->success(null,'User registered successfully');
    }
}
