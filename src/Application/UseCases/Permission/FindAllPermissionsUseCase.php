<?php

namespace Src\Application\UseCases\Permission;

use Src\Domain\Repositories\PermissionRepositoryInterface;

class FindAllPermissionsUseCase
{
    protected PermissionRepositoryInterface $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input)
    {
        return $this->repository->findAll();
    }
}
