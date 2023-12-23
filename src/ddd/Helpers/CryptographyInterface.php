<?php

namespace Src\Domain\Helpers;

interface CryptographyInterface
{
    public function compare(string $hash, string $value): bool;
}
