<?php

namespace Src\Infra\Repositories\RoleRepository;

use stdClass;
use Spatie\Permission\Models\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\Repositories\Role\{
    CreateRoleRepositoryInputDto
};

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

    public function find(string $id)
    {
        return $this->model
            ->where('id', $id)
            ->first();
    }

    public function findAll()
    {
        return $this->model
            ->where('guard_name', 'api')
            ->get();
    }

    public function findByName(array $input)
    {
        return $this->model
            ->where('guard_name', $input['guard_name'])
            ->where('name', $input['name'])
            ->first();
    }

    public function update(array $input, string $id)
    {
        return $this->model
            ->where('id', $id)
            ->update($input);
    }

    public function delete(string $id)
    {
        return $this->model
            ->where('id', $id)
            ->delete();
    }

    public function syncPermissions(array $input)
    {
        $role = $input['role'];
        $permissions = $input['permissions'];

        return $this->model
            ->where('name', $role)
            ->first()
            ->syncPermissions($permissions);
    }

    public function unsyncPermissions(array $input)
    {
        $role = $input['role'];
        $permissions = $input['permissions'];
        $output = false;

        foreach ($permissions as $permission) {
            $output = $this->model
                ->where('name', $role)
                ->first()
                ->revokePermissionTo($permission);
        }

        return $output;
    }
}
