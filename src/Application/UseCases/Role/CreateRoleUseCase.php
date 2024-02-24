<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Entities\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Create\CreateRoleUseCaseInputDto;
use Src\Domain\Dtos\Repositories\Role\CreateRoleRepositoryInputDto;

class CreateRoleUseCase
{
    protected RoleRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(string $name, string $guardName): void
    {
        $entity = new Role();

        $entity->create($name, $guardName);
    }

    protected function alreadyExists(string $name, string $guardName): bool
    {
        return !empty($this->repository->findByName($name, $guardName));
    }

    public function run(CreateRoleUseCaseInputDto $input): void
    {

        $name = $input->name;
        $guardName = $this->defaultGuardName;

        $this->valid($name, $guardName);

        $alreadyExists = $this->alreadyExists($name, $guardName);

        if ($alreadyExists) throw new BusinessException('Role already exists');

        $data = new CreateRoleRepositoryInputDto($name, $guardName);

        $this->repository->create($data);
    }
}
