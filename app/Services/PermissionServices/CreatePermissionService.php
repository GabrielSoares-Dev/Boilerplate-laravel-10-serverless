<?php

namespace App\Services\PermissionServices;

use App\Interfaces\Repositories\PermissionRepositoryInterface;
use App\Interfaces\Services\BaseServiceInterface;

class CreatePermissionService implements BaseServiceInterface
{
    protected PermissionRepositoryInterface $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input): array
    {
        $this->repository->create($input);

        return [
            'statusCode' => 201,
            'message' => 'Permission created successfully',
        ];
    }
}
