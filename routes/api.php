<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EmailVerificationController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

// api versions
Route::prefix('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->middleware(['api.maintenance'])
    ->group(function () {

        // unauthenticated routes
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:7,1');
        Route::post('/forget-password',[AuthController::class, 'forgetPassword']);
        Route::post('/reset-password/{token}',[AuthController::class, 'resetPassword']);

        // authenticated routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::get('/logout-all', [AuthController::class, 'logoutFromAllDevice']);

            Route::get('/resend-email-verification', [EmailVerificationController::class, 'resendVerification']);
            Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verify']);
            
            Route::get('/me', [ProfileController::class, 'show'])
                ->middleware(['force.password.change', 'account.active']);
            Route::post('/change-password', [AuthController::class, 'changePassword']);

            // admin routes
            Route::prefix('admin')
                ->middleware(['force.password.change', 'account.active'])
                ->group(function () {
                    Route::post('/maintenance', [SettingController::class, 'toggleMaintenance'])
                        ->middleware('permission:settings.maintenance.update');

                    Route::middleware('permission:roles.view')->apiResource('roles', RoleController::class);
                    Route::middleware('permission:permissions.view')->apiResource('permissions', PermissionController::class)
                        ->except(['show']);

                    Route::middleware('permission:users.view')->apiResource('/users', UserController::class);
                });
        });

    });
