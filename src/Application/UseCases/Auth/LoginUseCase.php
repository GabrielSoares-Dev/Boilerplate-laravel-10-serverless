<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\UseCases\Auth\Login\LoginUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Auth\Login\LoginUseCaseOutputDto;
use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Domain\Services\AuthServiceInterface;

class LoginUseCase
{
    protected AuthServiceInterface $authService;

    protected UserRepositoryInterface $userRepository;

    public function __construct(AuthServiceInterface $authService, UserRepositoryInterface $userRepository)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    protected function validateCredentials(string $email, string $password): void
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        $isInvalid = ! $this->authService->validateCredentials($credentials);

        if ($isInvalid) {
            throw new BusinessException('Invalid credentials');
        }
    }

    protected function generateToken(string $email): string
    {
        $input = $this->userRepository->findByEmail($email);

        return $this->authService->generateToken($input);
    }

    public function run(LoginUseCaseInputDto $input): LoginUseCaseOutputDto
    {
        $email = $input->email;
        $password = $input->password;

        $this->validateCredentials($email, $password);

        $token = $this->generateToken($email);

        return new LoginUseCaseOutputDto($token);
    }
}
