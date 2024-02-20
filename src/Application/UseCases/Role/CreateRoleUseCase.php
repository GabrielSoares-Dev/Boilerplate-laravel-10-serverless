<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Entities\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Create\CreateRoleUseCaseInputDto;

class CreateRoleUseCase
{
    protected RoleRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(array $input): void
    {
        $entity = new Role();

        $entity->create($input);
    }

    protected function alreadyExists(string $name, string $guardName): bool
    {
        return !empty($this->repository->findByName($name, $guardName));
    }

    public function run(CreateRoleUseCaseInputDto $input): void
    {

        $name = $input->name;
        $guardName = $this->defaultGuardName;

        $this->valid($input);

        $alreadyExists = $this->alreadyExists($name, $guardName);

        if ($alreadyExists) throw new BusinessException('Role already exists');

        $this->repository->create($input);
    }
}
