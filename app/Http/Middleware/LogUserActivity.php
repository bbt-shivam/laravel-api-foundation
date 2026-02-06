<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user()) {
            \App\Models\UserActivity::create([
                'user_id' => $request->user()->id,
                'action' => $request->route()?->getName() ?? 'api',
                'url' => $request->path(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'payload' => $request->except(['password','old_password','password_confirmation'])
            ]);
        }

        return $response;
    }
}
