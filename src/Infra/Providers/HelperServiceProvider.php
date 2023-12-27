<?php

namespace Src\Infra\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Helpers\CryptographyInterface;
use Src\Infra\Helpers\Cryptography;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CryptographyInterface::class, Cryptography::class);
    }
}
