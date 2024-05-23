<?php

namespace Src\Infra\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Repositories\UserRepositoryInterface;
use Src\Infra\Repositories\PermissionRepository\PermissionEloquentRepository;
use Src\Infra\Repositories\RoleRepository\RoleEloquentRepository;
use Src\Infra\Repositories\UserRepository\UserEloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionEloquentRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleEloquentRepository::class);
    }
}
