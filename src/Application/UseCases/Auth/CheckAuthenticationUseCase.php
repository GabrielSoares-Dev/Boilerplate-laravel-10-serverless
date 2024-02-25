<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Services\AuthServiceInterface;

class CheckAuthenticationUseCase
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function run(): void
    {
        $isUnauthorized = !$this->authService->validateToken();

        if ($isUnauthorized) throw new BusinessException('Unauthorized');
    }
}
