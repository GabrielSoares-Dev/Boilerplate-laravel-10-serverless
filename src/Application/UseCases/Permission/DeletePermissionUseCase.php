<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\UseCases\Permission\Delete\DeletePermissionUseCaseInputDto;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class DeletePermissionUseCase
{
    protected PermissionRepositoryInterface $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(DeletePermissionUseCaseInputDto $input): void
    {
        $id = $input->id;

        $deleted = $this->repository->delete($id);

        if (!$deleted) throw new BusinessException('Invalid id');
    }
}
