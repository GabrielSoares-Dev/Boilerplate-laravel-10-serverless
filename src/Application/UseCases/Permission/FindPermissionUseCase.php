<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use Src\Domain\Dtos\UseCases\Permission\Find\{
    FindPermissionUseCaseInputDto,
    FindPermissionUseCaseOutputDto
};

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

        $permission = $this->repository->find($id);

        if (!$permission) throw new BusinessException('Invalid id');

        return new FindPermissionUseCaseOutputDto(...(array) $permission);
    }
}
