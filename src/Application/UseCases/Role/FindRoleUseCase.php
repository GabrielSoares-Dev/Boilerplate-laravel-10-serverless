<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Find\{
    FindRoleUseCaseInputDto,
    FindRoleUseCaseOutputDto
};

class FindRoleUseCase
{
    protected RoleRepositoryInterface $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(FindRoleUseCaseInputDto $input): FindRoleUseCaseOutputDto
    {
        $id = $input->id;

        $role = $this->repository->find($id);

        if (!$role)  throw new BusinessException('Invalid id');

        return new FindRoleUseCaseOutputDto(...(array) $role);
    }
}
