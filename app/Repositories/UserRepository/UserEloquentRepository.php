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

    public function create(array $input)
    {
        return $this->model->create($input);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function createAccessToken(string $email, string $deviceName): string
    {
        $user = $this->model->where('email', $email)->first();

        return $user->createToken($deviceName)->plainTextToken;
    }
}
