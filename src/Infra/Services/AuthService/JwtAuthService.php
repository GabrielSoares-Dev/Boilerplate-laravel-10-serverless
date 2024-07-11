<?php

namespace Src\Infra\Services\AuthService;

use Illuminate\Support\Facades\Auth;
use Src\Application\Services\AuthServiceInterface;
use Src\Infra\Models\User;

class JwtAuthService implements AuthServiceInterface
{
    public function __construct(protected readonly User $model) {}

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
