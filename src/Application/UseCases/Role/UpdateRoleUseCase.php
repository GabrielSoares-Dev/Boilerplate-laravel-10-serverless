<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Entities\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;

class UpdateRoleUseCase implements BaseUseCaseInterface
{
    protected RoleRepositoryInterface $repository;

    protected $defaultGuardName = 'api';

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(array $input)
    {
        $entity = new Role();

        $entity->update($input);
    }

    public function run(array $input)
    {
        $id = $input['id'];

        $input['guard_name'] = $this->defaultGuardName;

        $this->valid($input);

        $updated = (bool) $this->repository->update($input, $id);

        if (! $updated) {
            throw new BusinessException('Invalid id');
        }
    }
}
