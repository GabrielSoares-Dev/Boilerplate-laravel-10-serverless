<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Services\AuthServiceInterface;
use Src\Application\Services\LoggerServiceInterface;

class LogoutUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly AuthServiceInterface $authService
    ) {}

    public function run(): void
    {
        $this->loggerService->info('START LogoutUseCase');

        $this->authService->logout();

        $this->loggerService->info('FINISH LogoutUseCase');
    }
}
