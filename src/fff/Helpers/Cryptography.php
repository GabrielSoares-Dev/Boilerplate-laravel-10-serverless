<?php

namespace Src\Infra\Helpers;

use Src\Domain\Helpers\CryptographyInterface;
use Illuminate\Support\Facades\Hash;

class Cryptography implements CryptographyInterface
{
    public function compare(string $hash, string $value): bool
    {
        return Hash::check($value, $hash);
    }
}
