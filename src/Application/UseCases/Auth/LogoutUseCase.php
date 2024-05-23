<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Services\AuthServiceInterface;
use Src\Application\Services\LoggerServiceInterface;

class LogoutUseCase
{
    protected LoggerServiceInterface $loggerService;

    protected AuthServiceInterface $authService;

    public function __construct(
        LoggerServiceInterface $loggerService,
        AuthServiceInterface $authService
    ) {
        $this->loggerService = $loggerService;
        $this->authService = $authService;
    }

    public function run(): void
    {
        $this->loggerService->info('START LogoutUseCase');

        $this->authService->logout();

        $this->loggerService->info('FINISH LogoutUseCase');
    }
}
