<?php

namespace Src\Infra\Repositories\RoleRepository;

use Spatie\Permission\Models\Role;
use Src\Application\Dtos\Repositories\Role\{SyncPermissionsRoleRepositoryDto};
use Src\Application\Dtos\Repositories\Role\CreateRoleRepositoryInputDto;
use Src\Application\Dtos\Repositories\Role\UnsyncPermissionsRoleRepositoryDto;
use Src\Application\Dtos\Repositories\Role\UpdateRoleRepositoryInputDto;
use Src\Application\Repositories\RoleRepositoryInterface;
use stdClass;

class RoleEloquentRepository implements RoleRepositoryInterface
{
    protected Role $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function create(CreateRoleRepositoryInputDto $input): stdClass
    {
        $data = [
            'name' => $input->name,
            'guard_name' => $input->guardName,
        ];
        $role = $this->model
            ->create($data);

        return (object) $role->toArray();
    }

    public function find(int $id): ?stdClass
    {
        $role = $this->model
            ->where('id', $id)
            ->first();

        return is_null($role) ? null : (object) $role->toArray();
    }

    public function findByName(string $name, string $guardName): ?stdClass
    {
        $role = $this->model
            ->where('guard_name', $guardName)
            ->where('name', $name)
            ->first();

        return is_null($role) ? null : (object) $role->toArray();
    }

    public function findAll(): array
    {
        return $this->model
            ->where('guard_name', 'api')
            ->get()
            ->toArray();
    }

    public function update(UpdateRoleRepositoryInputDto $input, int $id): bool
    {
        return $this->model
            ->where('id', $id)
            ->update((array) $input);
    }

    public function delete(int $id): bool
    {
        return $this->model
            ->where('id', $id)
            ->delete();
    }

    public function syncPermissions(SyncPermissionsRoleRepositoryDto $input): bool
    {
        $role = $input->role;
        $permissions = $input->permissions;

        return (bool) $this->model
            ->where('name', $role)
            ->first()
            ->syncPermissions($permissions);
    }

    public function unsyncPermissions(UnsyncPermissionsRoleRepositoryDto $input): bool
    {
        $role = $input->role;
        $permissions = $input->permissions;
        $output = false;

        foreach ($permissions as $permission) {
            $output = (bool) $this->model
                ->where('name', $role)
                ->first()
                ->revokePermissionTo($permission);
        }

        return $output;
    }
}
