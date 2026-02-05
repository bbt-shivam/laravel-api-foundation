<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{

    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if(!$user){
            return $this->error(
                'Unauthenticated',
                401,
                null,
                'AUTH_REQUIRED'
            );
        }

        if($user->deleted_at){
            return $this->error(
                'Account is deactivated',
                403,
                null,
                'ACCOUNT_DISABLED'
            );
        }

        if(!$user->hasVerifiedEmail()){
            return $this->error(
                'Email not verified',
                403,
                null,
                'EMAIL_NOT_VERIFIED'
            );
        }
        return $next($request);
    }
}
