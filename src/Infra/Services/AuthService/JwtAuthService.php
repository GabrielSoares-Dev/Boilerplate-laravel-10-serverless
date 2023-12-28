<?php

namespace Src\Infra\Services\AuthService;

use Illuminate\Support\Facades\Auth;
use Src\Domain\Services\AuthServiceInterface;

class JwtAuthService implements AuthServiceInterface
{
    public function generateToken($input)
    {
        return Auth::login($input);
    }

    public function validateCredentials(array $input)
    {
        return Auth::validate($input);
    }

    public function validateToken()
    {
        return Auth::authenticate();
    }

    public function logout()
    {
        return Auth::logout();
    }
}
