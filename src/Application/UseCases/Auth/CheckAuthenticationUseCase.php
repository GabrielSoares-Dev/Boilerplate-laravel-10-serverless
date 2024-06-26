<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Exceptions\BusinessException;
use Src\Application\Services\AuthServiceInterface;
use Src\Application\Services\LoggerServiceInterface;

class CheckAuthenticationUseCase
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
        $this->loggerService->info('START CheckAuthenticationUseCase');

        $isUnauthorized = !$this->authService->validateToken();

        if ($isUnauthorized) throw new BusinessException('Unauthorized');

        $this->loggerService->info('FINISH CheckAuthenticationUseCase');
    }
}
