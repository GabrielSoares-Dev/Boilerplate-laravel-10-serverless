<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\Repositories\Permission\UpdatePermissionRepositoryInputDto;
use Src\Domain\Dtos\UseCases\Permission\Update\UpdatePermissionUseCaseInputDto;
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

    protected function valid(string $name, string $guardName): void
    {
        $entity = new Permission();

        $entity->create($name, $guardName);
    }

    public function run(UpdatePermissionUseCaseInputDto $input): void
    {
        $id = $input->id;
        $name = $input->name;
        $guardName = $this->defaultGuardName;

        $this->valid($name, $guardName);

        $data = new UpdatePermissionRepositoryInputDto($name);

        $updated = $this->repository->update($data, $id);

        if (!$updated)  throw new BusinessException('Invalid id');
    }
}
