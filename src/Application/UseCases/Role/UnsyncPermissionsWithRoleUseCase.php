<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Dtos\Repositories\Role\UnsyncPermissionsRoleRepositoryDto;
use Src\Application\Dtos\UseCases\Role\UnsyncPermissionsWithRole\UnsyncPermissionsWithRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class UnsyncPermissionsWithRoleUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly RoleRepositoryInterface $roleRepository,
        protected readonly PermissionRepositoryInterface $permissionRepository
    ) {}

    protected string $defaultGuardName = 'api';

    protected function foundPermission(string $name): bool
    {
        $guardName = $this->defaultGuardName;

        return (bool) $this->permissionRepository->findByName($name, $guardName);
    }

    protected function validPermissions(array $permissions): void
    {

        foreach ($permissions as $permission) {
            $notFound = !$this->foundPermission($permission);

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

    public function run(UnsyncPermissionsWithRoleUseCaseInputDto $input): void
    {
        $this->loggerService->info('START UnsyncPermissionsWithRoleUseCase');

        $this->loggerService->debug('Input UnsyncPermissionsWithRoleUseCase', $input);

        $permissions = $input->permissions;
        $role = $input->role;

        $this->validPermissions($permissions);

        $this->validRole($role);

        $data = new UnsyncPermissionsRoleRepositoryDto($role, $permissions);

        $this->roleRepository->unsyncPermissions($data);

        $this->loggerService->info('FINISH UnsyncPermissionsWithRoleUseCase');
    }
}
