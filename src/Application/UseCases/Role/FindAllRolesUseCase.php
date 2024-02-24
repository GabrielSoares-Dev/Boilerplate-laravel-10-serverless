<?php

namespace Src\Application\UseCases\Role;

use Src\Domain\Repositories\RoleRepositoryInterface;

class FindAllRolesUseCase
{
    protected RoleRepositoryInterface $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(): array
    {
        return $this->repository->findAll();
    }
}
