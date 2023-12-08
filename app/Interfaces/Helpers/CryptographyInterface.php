<?php

namespace App\Interfaces\Helpers;

interface CryptographyInterface
{
    public function compare(string $hash,string $value): bool;
}
