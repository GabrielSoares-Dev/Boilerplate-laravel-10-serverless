<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Entities\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;

class CreateRoleUseCase
{
    protected RoleRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws BusinessException
     */
    protected function valid(array $input): void
    {
        $entity = new Role();

        $entity->create($input);
    }

    protected function alreadyExists(array $input): bool
    {
        return !empty($this->repository->findByName($input));
    }

    /**
     * @throws BusinessException
     */
    public function run(object $input): void
    {

        $input['guard_name'] = $this->defaultGuardName;

        $this->valid($input);

        $alreadyExists = $this->alreadyExists($input);

        if ($alreadyExists) {
            throw new BusinessException('Role already exists');
        }

        $this->repository->create($input);
    }
}
