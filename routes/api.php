<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::resource('user', UserController::class);
    Route::resource('permission', PermissionController::class);
});
