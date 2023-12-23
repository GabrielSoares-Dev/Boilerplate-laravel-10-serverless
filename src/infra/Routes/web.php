<?php

use Illuminate\Support\Facades\Route;
use Src\Infra\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('welcome');
});

