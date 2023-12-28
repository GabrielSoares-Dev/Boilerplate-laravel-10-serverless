<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Services\AuthServiceInterface;

class LogoutUseCase implements BaseUseCaseInterface
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function run(array $input)
    {
        $this->authService->logout();
    }
}
