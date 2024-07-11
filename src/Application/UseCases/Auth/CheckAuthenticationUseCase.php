<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Exceptions\BusinessException;
use Src\Application\Services\AuthServiceInterface;
use Src\Application\Services\LoggerServiceInterface;

class CheckAuthenticationUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly AuthServiceInterface $authService
    ) {}

    public function run(): void
    {
        $this->loggerService->info('START CheckAuthenticationUseCase');

        $isUnauthorized = !$this->authService->validateToken();

        if ($isUnauthorized) throw new BusinessException('Unauthorized');

        $this->loggerService->info('FINISH CheckAuthenticationUseCase');
    }
}
