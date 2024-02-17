<?php

namespace Src\Infra\Repositories\PermissionRepository;

use Spatie\Permission\Models\Permission;
use Src\Domain\Dtos\Repositories\Permission\CreatePermissionInputDto;
use Src\Domain\Dtos\Repositories\Permission\UpdatePermissionInputDto;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use stdClass;

class PermissionEloquentRepository implements PermissionRepositoryInterface
{
    protected Permission $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function create(CreatePermissionInputDto $input): stdClass
    {
        $permission = $this->model
            ->create((array) $input);

        return (object) $permission->toArray();
    }

    public function find(int $id): ?stdClass
    {
        $permission = $this->model
            ->where('id', $id)
            ->first();

        return (object) $permission->toArray();
    }

    public function findByName(string $name, string $guardName): ?stdClass
    {
        $permission = $this->model
            ->where('guard_name', $guardName)
            ->where('name', $name)
            ->first();

        return (object) $permission->toArray();
    }

    public function findAll(): array
    {
        return $this->model
            ->where('guard_name', 'api')
            ->get()
            ->toArray();
    }

    public function update(UpdatePermissionInputDto $input, int $id): ?stdClass
    {
        $permission = $this->model
            ->where('id', $id)
            ->update((array) $input);

        return (object) $permission->toArray();
    }

    public function delete(int $id): void
    {
        $this->model
            ->where('id', $id)
            ->delete();
    }
}
