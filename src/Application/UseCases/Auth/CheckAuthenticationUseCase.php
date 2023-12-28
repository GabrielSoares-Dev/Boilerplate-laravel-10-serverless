<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Services\AuthServiceInterface;

class CheckAuthenticationUseCase implements BaseUseCaseInterface
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function run(array $input)
    {
        $isUnauthorized = ! $this->authService->validateToken();

        if ($isUnauthorized) {
            throw new BusinessException('Unauthorized');
        }
    }
}
