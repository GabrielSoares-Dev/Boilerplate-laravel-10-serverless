<?php

namespace App\Repositories\UserRepository;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $input): User
    {
        return $this->model->create($input);
    }

    public function findByEmail(string $email): User
    {
        return $this->model->where('email', $email)->first();
    }
}
