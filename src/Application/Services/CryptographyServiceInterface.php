<?php

namespace Src\Application\Services;

interface CryptographyServiceInterface
{
    public function compare(string $hash, string $value): bool;
}
