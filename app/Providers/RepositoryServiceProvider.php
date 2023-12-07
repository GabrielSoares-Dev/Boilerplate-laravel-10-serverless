<?php

namespace App\Providers;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
    }
}
