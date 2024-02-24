<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\SyncPermissionsWithRole\SyncPermissionsWithRoleUseCaseInputDto;
use Src\Domain\Dtos\Repositories\Role\SyncPermissionsRoleRepositoryDto;

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

    protected function foundPermission(string $name): bool
    {
        $guardName = $this->defaultGuardName;

        return (bool) $this->permissionRepository->findByName($name, $guardName);
    }

    protected function validPermissions(array $permissions): void
    {
        $guardName = $this->defaultGuardName;

        foreach ($permissions as $permission) {
            $notFound = !$this->foundPermission($permission, $guardName);

            if ($notFound) throw new BusinessException('Invalid permission');
        }
    }

    protected function foundRole(string $name): bool
    {
        $guardName = $this->defaultGuardName;

        return (bool) $this->roleRepository->findByName($name, $guardName);
    }

    protected function validRole(string $role): void
    {
        $notFound = !$this->foundRole($role);

        if ($notFound) throw new BusinessException('Invalid role');
    }

    public function run(SyncPermissionsWithRoleUseCaseInputDto $input): void
    {
        $permissions = $input->permissions;
        $role = $input->role;

        $this->validPermissions($permissions);

        $this->validRole($role);

        $data = new SyncPermissionsRoleRepositoryDto($role, $permissions);

        $this->roleRepository->syncPermissions($data);
    }
}
