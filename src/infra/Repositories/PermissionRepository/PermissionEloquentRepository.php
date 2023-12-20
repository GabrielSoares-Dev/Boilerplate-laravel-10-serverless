<?php

namespace Src\Infra\Repositories\PermissionRepository;

use Src\Domain\Repositories\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionEloquentRepository implements PermissionRepositoryInterface
{
    protected Permission $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function create(array $input)
    {
        return $this->model->create($input);
    }
}
