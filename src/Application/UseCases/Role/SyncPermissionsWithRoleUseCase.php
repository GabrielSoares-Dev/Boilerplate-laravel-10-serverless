<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Dtos\Repositories\Role\SyncPermissionsRoleRepositoryDto;
use Src\Application\Dtos\UseCases\Role\SyncPermissionsWithRole\SyncPermissionsWithRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class SyncPermissionsWithRoleUseCase
{
    public function __construct(
        private readonly LoggerServiceInterface $loggerService,
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly PermissionRepositoryInterface $permissionRepository
    ) {}

    private string $defaultGuardName = 'api';

    private function foundPermission(string $name): bool
    {
        $guardName = $this->defaultGuardName;

        return (bool) $this->permissionRepository->findByName($name, $guardName);
    }

    private function validPermissions(array $permissions): void
    {
        foreach ($permissions as $permission) {
            $notFound = !$this->foundPermission($permission);

            if ($notFound) throw new BusinessException('Invalid permission');
        }
    }

    private function foundRole(string $name): bool
    {
        $guardName = $this->defaultGuardName;

        return (bool) $this->roleRepository->findByName($name, $guardName);
    }

    private function validRole(string $role): void
    {
        $notFound = !$this->foundRole($role);

        if ($notFound) throw new BusinessException('Invalid role');
    }

    public function run(SyncPermissionsWithRoleUseCaseInputDto $input): void
    {
        $this->loggerService->info('START SyncPermissionsWithRoleUseCase');

        $this->loggerService->debug('Input SyncPermissionsWithRoleUseCase', $input);

        $permissions = $input->permissions;
        $role = $input->role;

        $this->validPermissions($permissions);

        $this->validRole($role);

        $data = new SyncPermissionsRoleRepositoryDto($role, $permissions);

        $this->roleRepository->syncPermissions($data);

        $this->loggerService->info('FINISH SyncPermissionsWithRoleUseCase');
    }
}
