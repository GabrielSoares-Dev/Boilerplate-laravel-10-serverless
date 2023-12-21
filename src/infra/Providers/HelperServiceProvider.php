<?php

namespace Src\Infra\Providers;

use Src\Infra\Helpers\Cryptography;
use Src\Domain\Helpers\CryptographyInterface;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CryptographyInterface::class, Cryptography::class);
    }
}
