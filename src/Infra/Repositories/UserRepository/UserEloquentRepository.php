<?php

namespace Src\Infra\Repositories\UserRepository;

use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Infra\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $input)
    {
        return $this->model->create($input);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function assignRole(array $input)
    {
        $role = $input['role'];
        $email = $input['email'];

        return $this->model->where('email', $email)->first()->assignRole($role);
    }
}
