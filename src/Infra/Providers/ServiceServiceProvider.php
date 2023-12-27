<?php

namespace Src\Infra\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Services\AuthServiceInterface;
use Src\Infra\Services\AuthService\JwtAuthService;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, JwtAuthService::class);
    }
}
