<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ApiMaintenanceMode;
use App\Http\Middleware\EnsureAccountIsActive;
use App\Http\Middleware\ForcePasswordChange;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->api([
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
        ]);
        $middleware->alias([
            'api.maintenance' => ApiMaintenanceMode::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'force.password.change' => ForcePasswordChange::class,
            'account.active' => EnsureAccountIsActive::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {

            if ($request->is('api/*')) {
                $request->headers->set('Accept', 'application/json');
            }

            if (! $request->expectsJson() && ! $request->is('api/*')) {
                return null;
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'error' => [
                        'status' => 422,
                        'message' => $e->getMessage(),
                        'errors' => $e->errors(),
                    ]
                ], 422);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'error' => [
                        'status' => 401,
                        'message' => 'Unauthenticated.',
                    ]
                ], 401);
            }

            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return response()->json([
                    'error' => [
                        'status' => 403,
                        'message' => 'Forbidden! This action is unauthorized.',
                    ]
                ], 403);
            }

            $status = $e instanceof HttpExceptionInterface
                ? $e->getStatusCode()
                : 500;

            $message = app()->isProduction()
                ? 'Something went wrong'
                : $e->getMessage();

            return response()->json([
                'error' => [
                    'status' => $status,
                    'message' => $message,
                ]
            ], $status);
        });
    })->create();
