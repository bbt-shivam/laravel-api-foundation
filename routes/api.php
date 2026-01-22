<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\SettingController;

// api versions
Route::prefix('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->middleware('api.maintenance')
    ->group(function (){

        // unauthenticated routes
        Route::post('/login', [AuthController::class, 'login']);

        //authenticated routes
        Route::middleware('auth:sanctum')->group(function(){
            Route::get('/logout',[AuthController::class, 'logout']);
            Route::get('/profile', [ProfileController::class, 'show']);
            Route::post('/change-password', [AuthController::class, 'changePassword']);
            
            Route::post('/maintenance', [SettingController::class, 'toggleMaintenance'])
                ->middleware('permission:edit-setting-maintenance');

            //admin routes
            Route::prefix('admin')
                ->middleware('role:admin')
                ->group(function() {

                    Route::apiResource('roles', RoleController::class);
                    Route::apiResource('permissions', PermissionController::class)->except(['show']);

                    Route::get('/users', [AdminUserController::class, 'index']);
                    Route::delete('/users/{id}', [AdminUserController::class, 'destroy']); 
            });


        });

    });
