<?php

namespace Src\Infra\Repositories\UserRepository;

use stdClass;
use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Infra\Models\User;
use Src\Domain\Dtos\Repositories\User\{
    CreateUserRepositoryInputDto,
    AssignRoleRepositoryInputDto
};

class UserEloquentRepository implements UserRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(CreateUserRepositoryInputDto $input): stdClass
    {
        $data = [
            'name' => $input->name,
            'email' => $input->email,
            'phone_number' => $input->phoneNumber,
            'password' => $input->password,
        ];

        $user = $this->model->create($data);

        return (object) $user->toArray();
    }

    public function findByEmail(string $email): ?stdClass
    {
        $user = $this->model->where('email', $email)->first();

        return is_null($user) ? null : (object) $user->toArray();
    }

    public function assignRole(AssignRoleRepositoryInputDto $input): bool
    {
        $role = $input->role;
        $email = $input->email;

        return (bool) $this->model->where('email', $email)->first()->assignRole($role);
    }
}
