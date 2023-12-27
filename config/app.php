<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'name' => env('APP_NAME', 'Laravel'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'asset_url' => env('ASSET_URL'),
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'maintenance' => [
        'driver' => 'file',
        // 'store' => 'redis',
    ],

    'providers' => ServiceProvider::defaultProviders()->merge([
        Src\Infra\Providers\AppServiceProvider::class,
        Src\Infra\Providers\AuthServiceProvider::class,
        Src\Infra\Providers\ServiceServiceProvider::class,
        Src\Infra\Providers\RepositoryServiceProvider::class,
        Src\Infra\Providers\HelperServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        Src\Infra\Providers\EventServiceProvider::class,
        Src\Infra\Providers\RouteServiceProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),

];
