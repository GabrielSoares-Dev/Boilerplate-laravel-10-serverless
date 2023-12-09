<?php

namespace App\Providers;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Repositories\PermissionRepositoryInterface;

use App\Repositories\UserRepository\UserEloquentRepository;
use App\Repositories\PermissionRepository\PermissionEloquentRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionEloquentRepository::class);
    }
}
