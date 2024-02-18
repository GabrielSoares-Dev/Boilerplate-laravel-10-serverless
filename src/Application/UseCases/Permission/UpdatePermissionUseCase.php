<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Entities\Permission;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class UpdatePermissionUseCase
{
    protected PermissionRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(array $input)
    {
        $entity = new Permission();

        $entity->update($input);
    }

    public function run(array $input)
    {
        $id = $input['id'];

        $input['guard_name'] = $this->defaultGuardName;

        $this->valid($input);

        $updated = (bool) $this->repository->update($input, $id);

        if (!$updated) {
            throw new BusinessException('Invalid id');
        }
    }
}
