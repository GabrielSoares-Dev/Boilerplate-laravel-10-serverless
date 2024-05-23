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
    protected LoggerServiceInterface $loggerService;

    protected RoleRepositoryInterface $roleRepository;

    protected PermissionRepositoryInterface $permissionRepository;

    protected string $defaultGuardName = 'api';

    public function __construct(
        LoggerServiceInterface $loggerService,
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->loggerService = $loggerService;
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
