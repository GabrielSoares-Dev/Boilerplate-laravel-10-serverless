<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Entities\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;

class UpdateRoleUseCase
{
    protected RoleRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input): void
    {
        $id = $input['id'];

        $input['guard_name'] = $this->defaultGuardName;

        $this->valid($input);

        $updated = (bool) $this->repository->update($input, $id);

        if (! $updated) {
            throw new BusinessException('Invalid id');
        }
    }

    protected function valid(array $input): void
    {
        $entity = new Role();

        $entity->update($input);
    }
}
