<?php

namespace App\Services\UserServices;

use App\Exceptions\BusinessException;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\BaseServiceInterface;

class CreateUserService implements BaseServiceInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function foundUserBySameEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function run(array $input):array
    {

        $email = $input['email'];

        if ($this->foundUserBySameEmail($email)) {
            throw new BusinessException('User already exists', 400);
        }

        $this->repository->create($input);

        return [
            'statusCode' => 201,
            'message' => 'User created successfully',
        ];
    }
}
