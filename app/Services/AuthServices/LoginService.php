<?php

namespace App\Services\AuthServices;

use App\Exceptions\BusinessException;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\BaseServiceInterface;

class LoginService implements BaseServiceInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input)
    {

      
    }
}
