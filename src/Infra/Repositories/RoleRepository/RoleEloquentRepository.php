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

    public function findByName(array $input)
    {
        return $this->model
            ->where('guard_name', $input['guard_name'])
            ->where('name', $input['name'])
            ->first();
    }
}
