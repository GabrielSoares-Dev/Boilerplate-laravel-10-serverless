<?php

namespace App\Services\AuthServices;

use App\Exceptions\BusinessException;
use App\Interfaces\Helpers\CryptographyInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\BaseServiceInterface;

class LoginService implements BaseServiceInterface
{
    protected UserRepositoryInterface $repository;

    protected CryptographyInterface $cryptography;

    public function __construct(UserRepositoryInterface $repository, CryptographyInterface $cryptography)
    {
        $this->repository = $repository;
        $this->cryptography = $cryptography;
    }

    protected function foundUserByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function run(array $input): array
    {

        $email = $input['email'];
        $password = $input['password'];
        $deviceName = $input['device_name'];

        $user = $this->foundUserByEmail($email);

        $invalidCredentials = ! $user || ! $this->cryptography->compare($user->password, $password);

        if ($invalidCredentials) {
            throw new BusinessException('Invalid credentials', 401);
        }

        $accessToken = $user->createToken($deviceName)->plainTextToken;

        $content = [
            'accessToken' => $accessToken,
        ];

        return [
            'statusCode' => 200,
            'message' => 'Authenticated',
            'content' => $content,
        ];
    }
}
