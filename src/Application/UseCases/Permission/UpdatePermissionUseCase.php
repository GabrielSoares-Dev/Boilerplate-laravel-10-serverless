<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Entities\Permission;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class UpdatePermissionUseCase implements BaseUseCaseInterface
{
    protected PermissionRepositoryInterface $repository;

    protected $defaultGuardName = 'api';

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function validPermission(array $input)
    {
        $permissionEntity = new Permission();

        $permissionEntity->update($input);
    }

    public function run(array $input)
    {
        $id = $input['id'];

        $input['guard_name'] = $this->defaultGuardName;

        $this->validPermission($input);

        $updated = (bool) $this->repository->update($input, $id);

        if (! $updated) {
            throw new BusinessException('Invalid id');
        }
    }
}
