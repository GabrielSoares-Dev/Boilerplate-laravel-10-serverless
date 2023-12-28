<?php

namespace Src\Domain\Services;

interface AuthServiceInterface
{
    public function generateToken($input);

    public function validateCredentials(array $input);

    public function validateToken();

    public function logout();
}
