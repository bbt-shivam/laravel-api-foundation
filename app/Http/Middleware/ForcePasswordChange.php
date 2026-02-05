<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponse;

class ForcePasswordChange
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
        if($user && $user->must_change_password){
            return $this->error(
                message: 'Password change required',
                status: 403,
                code: 'PASSWORD_RESET_REQUIRED'
            );
        }
        return $next($request);
    }
}
