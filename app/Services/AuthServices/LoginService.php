<?php

namespace App\Services\AuthServices;

use App\Exceptions\BusinessException;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\BaseServiceInterface;
use Illuminate\Support\Facades\Hash;

class LoginService implements BaseServiceInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function foundUserByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function run(array $input)
    {

        $email = $input['email'];
        $password = $input['password'];
        $deviceName = $input['device_name'];

        $user = $this->foundUserByEmail($email);

        $invalidCredentials = ! $user || Hash::check($password, $user->password);

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
