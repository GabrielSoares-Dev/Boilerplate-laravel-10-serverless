<?php

namespace Src\Application\UseCases\Auth;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Domain\Services\AuthServiceInterface;

class LoginUseCase implements BaseUseCaseInterface
{
    protected AuthServiceInterface $authService;

    protected UserRepositoryInterface $userRepository;

    public function __construct(AuthServiceInterface $authService, UserRepositoryInterface $userRepository)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    protected function validateCredentials(string $email, string $password)
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

    protected function generateToken(string $email)
    {
        $input = $this->userRepository->findByEmail($email);

        return $this->authService->generateToken($input);
    }

    public function run(array $input)
    {
        $email = $input['email'];
        $password = $input['password'];

        $this->validateCredentials($email, $password);

        $token = $this->generateToken($email);

        $output = [
            'token' => $token,
        ];

        return $output;
    }
}
