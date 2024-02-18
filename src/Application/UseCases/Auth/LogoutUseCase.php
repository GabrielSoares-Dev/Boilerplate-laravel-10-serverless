<?php

namespace Src\Application\UseCases\Auth;

use Src\Domain\Services\AuthServiceInterface;

class LogoutUseCase
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function run(): void
    {
        $this->authService->logout();
    }
}
