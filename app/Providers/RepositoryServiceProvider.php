<?php

namespace App\Providers;

use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use Src\Infra\Repositories\UserRepository\UserEloquentRepository;
use Src\Infra\Repositories\PermissionRepository\PermissionEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionEloquentRepository::class);
    }
}
