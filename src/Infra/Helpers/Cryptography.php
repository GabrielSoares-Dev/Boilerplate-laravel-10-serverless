<?php

namespace Src\Infra\Helpers;

use Illuminate\Support\Facades\Hash;

class Cryptography implements \Src\Application\Helpers\CryptographyInterface
{
    public function compare(string $hash, string $value): bool
    {
        return Hash::check($value, $hash);
    }
}
