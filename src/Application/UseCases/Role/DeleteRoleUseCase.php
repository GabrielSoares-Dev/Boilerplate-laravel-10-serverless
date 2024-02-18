<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Repositories\RoleRepositoryInterface;

class DeleteRoleUseCase
{
    protected RoleRepositoryInterface $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input)
    {
        $id = $input['id'];

        $deleted = $this->repository->delete($id);

        if (!$deleted) {
            throw new BusinessException('Invalid id');
        }
    }
}
