<?php

namespace Src\Infra\Repositories\RoleRepository;

use Spatie\Permission\Models\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;

class RoleEloquentRepository implements RoleRepositoryInterface
{
    protected Role $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function create(array $input)
    {
        return $this->model
            ->create($input);
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
}
