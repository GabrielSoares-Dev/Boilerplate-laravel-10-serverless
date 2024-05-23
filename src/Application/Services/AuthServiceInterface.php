<?php

namespace Src\Application\Services;

interface AuthServiceInterface
{
    public function generateToken(string $email): string;

    public function validateCredentials(string $email, string $password): bool;

    public function validateToken(): bool;

    public function logout(): void;
}
