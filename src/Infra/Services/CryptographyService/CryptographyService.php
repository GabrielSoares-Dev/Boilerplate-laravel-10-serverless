<?php

namespace Src\Infra\Services\CryptographyService;

use Illuminate\Support\Facades\Hash;
use Src\Application\Services\CryptographyServiceInterface;

class CryptographyService implements CryptographyServiceInterface
{
    public function compare(string $hash, string $value): bool
    {
        return Hash::check($value, $hash);
    }
}
