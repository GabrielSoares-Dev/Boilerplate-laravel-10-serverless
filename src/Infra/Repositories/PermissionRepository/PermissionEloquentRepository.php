<?php

namespace Src\Infra\Repositories\PermissionRepository;

use Spatie\Permission\Models\Permission;
use Src\Application\Dtos\Repositories\Permission\CreatePermissionRepositoryInputDto;
use Src\Application\Dtos\Repositories\Permission\UpdatePermissionRepositoryInputDto;
use Src\Application\Repositories\PermissionRepositoryInterface;
use stdClass;

class PermissionEloquentRepository implements PermissionRepositoryInterface
{
    public function __construct(protected readonly Permission $model) {}

    public function create(CreatePermissionRepositoryInputDto $input): stdClass
    {
        $data = [
            'name' => $input->name,
            'guard_name' => $input->guardName,
        ];
        $permission = $this->model
            ->create($data);

        return (object) $permission->toArray();
    }

    public function find(int $id): ?stdClass
    {
        $permission = $this->model
            ->where('id', $id)
            ->first();

        return is_null($permission) ? null : (object) $permission->toArray();
    }

    public function findByName(string $name, string $guardName): ?stdClass
    {
        $permission = $this->model
            ->where('guard_name', $guardName)
            ->where('name', $name)
            ->first();

        return is_null($permission) ? null : (object) $permission->toArray();
    }

    public function findAll(): array
    {
        return $this->model
            ->where('guard_name', 'api')
            ->get()
            ->toArray();
    }

    public function update(UpdatePermissionRepositoryInputDto $input, int $id): bool
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
}
