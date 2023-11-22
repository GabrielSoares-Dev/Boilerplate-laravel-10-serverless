<?php

namespace App\Services\UserServices;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\BaseServiceInterface;

class CreateUserService implements BaseServiceInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input)
    {
        $this->repository->create($input);

        return [
            'statusCode' => 201,
            'Message' => 'User created successfully',
        ];
    }
}
