<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\Repositories\Permission\CreatePermissionRepositoryInputDto;
use Src\Domain\Dtos\UseCases\Permission\Create\CreatePermissionUseCaseInputDto;
use Src\Domain\Entities\Permission;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class CreatePermissionUseCase
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

    protected function alreadyExists(string $name, string $guardName): bool
    {
        return ! empty($this->repository->findByName($name, $guardName));
    }

    public function run(CreatePermissionUseCaseInputDto $input): void
    {
        $name = $input->name;
        $guardName = $this->defaultGuardName;

        $this->valid($name, $guardName);

        $alreadyExists = $this->alreadyExists($name, $guardName);

        if ($alreadyExists) {
            throw new BusinessException('Permission already exists');
        }

        $data = new CreatePermissionRepositoryInputDto($name, $guardName);

        $this->repository->create($data);
    }
}
