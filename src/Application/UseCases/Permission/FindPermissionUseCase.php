<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\UseCases\Permission\Find\FindPermissionUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Permission\Find\FindPermissionUseCaseOutputDto;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class FindPermissionUseCase
{
    protected PermissionRepositoryInterface $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(FindPermissionUseCaseInputDto $input): FindPermissionUseCaseOutputDto
    {
        $id = $input->id;

        $permission = (array) $this->repository->find($id);

        if (!$permission) throw new BusinessException('Invalid id');

        return new FindPermissionUseCaseOutputDto($permission->id, $permission->name, $permission->guard_name, $permission->created_at, $permission->updated_at);
    }
}
