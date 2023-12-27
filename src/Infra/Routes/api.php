<?php

use Illuminate\Support\Facades\Route;
use Src\Infra\Http\Controllers\PermissionController;
use Src\Infra\Http\Controllers\RoleController;
use Src\Infra\Http\Controllers\UserController;

Route::prefix('v1')->group(function () {
    Route::resource('user', UserController::class);

    Route::resource('permission', PermissionController::class);

    Route::resource('role', RoleController::class);

    Route::prefix('role')->group(function () {
        Route::post('/sync-permissions', [RoleController::class, 'syncPermissions']);
        Route::post('/unsync-permissions', [RoleController::class, 'unsyncPermissions']);
    });
});
