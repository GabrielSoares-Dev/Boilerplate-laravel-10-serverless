<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;

class SyncPermissionsWithRoleUseCase
{
    protected RoleRepositoryInterface $roleRepository;

    protected PermissionRepositoryInterface $permissionRepository;

    protected string $defaultGuardName = 'api';

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    protected function foundPermission(string $name)
    {
        $input = [
            'guard_name' => $this->defaultGuardName,
            'name' => $name,
        ];

        return (bool) $this->permissionRepository->findByName($input);
    }

    protected function validPermissions(array $input)
    {
        $permissions = $input['permissions'];

        foreach ($permissions as $permission) {
            $notFound = !$this->foundPermission($permission);

            if ($notFound) {
                throw new BusinessException('Invalid permission');
            }
        }
    }

    protected function foundRole(string $name)
    {
        $input = [
            'guard_name' => $this->defaultGuardName,
            'name' => $name,
        ];

        return (bool) $this->roleRepository->findByName($input);
    }

    protected function validRole(array $input)
    {
        $role = $input['role'];

        $notFound = !$this->foundRole($role);

        if ($notFound) {
            throw new BusinessException('Invalid role');
        }
    }

    public function run(array $input)
    {
        $this->validPermissions($input);

        $this->validRole($input);

        $this->roleRepository->syncPermissions($input);
    }
}
