<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Dtos\UseCases\Auth\Login\LoginUseCaseInputDto;
use Src\Application\Dtos\UseCases\Auth\Login\LoginUseCaseOutputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Services\AuthServiceInterface;
use Src\Application\Services\LoggerServiceInterface;

class LoginUseCase
{
    public function __construct(
        private readonly LoggerServiceInterface $loggerService,
        private readonly AuthServiceInterface $authService
    ) {}

    private function validateCredentials(string $email, string $password): void
    {
        $isInvalid = !$this->authService->validateCredentials($email, $password);

        if ($isInvalid) throw new BusinessException('Invalid credentials');
    }

    private function generateToken(string $email): string
    {
        return $this->authService->generateToken($email);
    }

    public function run(LoginUseCaseInputDto $input): LoginUseCaseOutputDto
    {
        $this->loggerService->info('START LoginUseCase');

        $this->loggerService->debug('Input LoginUseCase', $input);

        $email = $input->email;
        $password = $input->password;

        $this->validateCredentials($email, $password);

        $token = $this->generateToken($email);

        $this->loggerService->info('FINISH LoginUseCase');

        return new LoginUseCaseOutputDto($token);
    }
}
