<?php

namespace App\Providers;

use App\Helpers\Cryptography;
use App\Interfaces\Helpers\CryptographyInterface;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CryptographyInterface::class, Cryptography::class);
    }
}
