<?php

use Src\Infra\Http\Controllers\PermissionController;
use Src\Infra\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('permission', PermissionController::class);
});
