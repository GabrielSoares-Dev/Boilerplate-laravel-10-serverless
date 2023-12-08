<?php

namespace App\Repositories\UserRepository;

use App\Interfaces\Repositories\UserRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionEloquentRepository implements UserRepositoryInterface
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
