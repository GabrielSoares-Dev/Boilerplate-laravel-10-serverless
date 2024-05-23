<?php

namespace Src\Application\Helpers;

interface CryptographyInterface
{
    public function compare(string $hash, string $value): bool;
}
