<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Entities\Permission;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class CreatePermissionUseCase implements BaseUseCaseInterface
{
    protected PermissionRepositoryInterface $repository;

    protected $defaultGuardName = 'api';

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function validPermission(array $input): void
    {
        $permissionEntity = new Permission();

        $permissionEntity->create($input);
    }

    protected function alreadyExists(array $input): bool
    {
        return ! empty($this->repository->findByName($input));
    }

    public function run(array $input): void
    {

        $input['guard_name'] = $this->defaultGuardName;

        $this->validPermission($input);

        $alreadyExists = $this->alreadyExists($input);

        if ($alreadyExists) {
            throw new BusinessException('Permission already exists');
        }

        $this->repository->create($input);
    }
}
