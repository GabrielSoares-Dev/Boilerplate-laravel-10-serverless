<?php

namespace Src\Application\UseCases\Role;

use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;

class FindAllRolesUseCase implements BaseUseCaseInterface
{
    protected RoleRepositoryInterface $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input)
    {
        return $this->repository->findAll();
    }
}
