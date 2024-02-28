<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\UseCases\Auth\Login\LoginUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Auth\Login\LoginUseCaseOutputDto;
use Src\Domain\Services\LoggerServiceInterface;
use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Domain\Services\AuthServiceInterface;

class LoginUseCase
{
    protected LoggerServiceInterface $loggerService;

    protected AuthServiceInterface $authService;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        LoggerServiceInterface $loggerService,
        AuthServiceInterface $authService,
        UserRepositoryInterface $userRepository
    ) {
        $this->loggerService = $loggerService;
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    protected function validateCredentials(string $email, string $password): void
    {
        $isInvalid = !$this->authService->validateCredentials($email, $password);

        if ($isInvalid) throw new BusinessException('Invalid credentials');
    }

    protected function generateToken(string $email): string
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
