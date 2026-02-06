<?php

use App\Http\Controllers\Api\V1\AuthController;
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
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

        // authenticated routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::get('/profile', [ProfileController::class, 'show'])
                ->middleware(['force.password.change', 'account.active']);
            Route::post('/change-password', [AuthController::class, 'changePassword']);

            // admin routes
            Route::prefix('admin')
                ->middleware(['force.password.change', 'account.active'])
                ->group(function () {
                    Route::post('/maintenance', [SettingController::class, 'toggleMaintenance'])
                        ->middleware('permission:edit-setting-maintenance');

                    Route::middleware('permission:access-roles')->apiResource('roles', RoleController::class);
                    Route::middleware('permission:access-permissions')->apiResource('permissions', PermissionController::class)
                        ->except(['show']);

                    Route::middleware('permission:access-users')->apiResource('/users', UserController::class);
                });

        });

    });
