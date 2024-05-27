<?php

namespace Src\Infra\Helpers;

use Illuminate\Support\Facades\Hash;
use Src\Application\Helpers\CryptographyInterface;

class Cryptography implements CryptographyInterface
{
    public function compare(string $hash, string $value): bool
    {
        return Hash::check($value, $hash);
    }
}
