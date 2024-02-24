<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Entities\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\Repositories\Role\UpdateRoleRepositoryInputDto;
use Src\Domain\Dtos\UseCases\Role\Update\UpdateRoleUseCaseInputDto;

class UpdateRoleUseCase
{
    protected RoleRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(string $name): void
    {
        $guardName = $this->defaultGuardName;

        $entity = new Role();

        $entity->update($name, $guardName);
    }

    public function run(UpdateRoleUseCaseInputDto $input): void
    {
        $id = $input->id;
        $name = $input->name;

        $this->valid($name);

        $data = new UpdateRoleRepositoryInputDto($name);
        $updated = (bool) $this->repository->update($data, $id);

        if (!$updated) throw new BusinessException('Invalid id');
    }
}
