<?php

namespace Src\Infra\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Application\Services\AuthServiceInterface;
use Src\Application\Services\LoggerServiceInterface;
use Src\Infra\Services\AuthService\JwtAuthService;
use Src\Infra\Services\LoggerService\LoggerService;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, JwtAuthService::class);
        $this->app->bind(LoggerServiceInterface::class, LoggerService::class);
    }
}
