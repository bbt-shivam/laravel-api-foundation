<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\VerifyEmailRequest;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(VerifyEmailRequest $request, EmailVerificationService $emailVerificationService){
        $emailVerificationService->verify($request->validated('token'));
        return $this->success(null, 'Email Verified successfully');
    }

    public function resendVerification(Request $request, EmailVerificationService $emailVerificationService){
        $emailVerificationService->resendVerificationLink($request->user());
        return $this->success(null, 'Verification email resent successfully');
    }
}
