<?php

namespace Src\Infra\Services\AuthService;

use Illuminate\Support\Facades\Auth;
use Src\Domain\Services\AuthServiceInterface;
use Src\Infra\Models\User;

class JwtAuthService implements AuthServiceInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function generateToken(string $email): string
    {
        $user = $this->model->where('email', $email)->first();

        return (string) Auth::login($user);
    }

    public function validateCredentials(string $email, string $password): bool
    {
        $input = [
            'email' => $email,
            'password' => $password,
        ];

        return Auth::validate($input);
    }

    public function validateToken(): bool
    {
        return (bool) Auth::authenticate();
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
