<?php

namespace Src\Application\UseCases\User;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Entities\User;
use Src\Domain\Enums\Role;
use Src\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCase implements BaseUseCaseInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(array $input)
    {
        $entity = new User();

        $entity->create($input);
    }

    protected function foundUserBySameEmail(string $email)
    {
        return (bool) $this->repository->findByEmail($email);
    }

    protected function assignRole(string $email)
    {
        $input = [
            'email' => $email,
            'role' => Role::ADMIN,
        ];

        $this->repository->assignRole($input);
    }

    public function run(array $input)
    {

        $this->valid($input);

        $email = $input['email'];

        if ($this->foundUserBySameEmail($email)) {
            throw new BusinessException('User already exists');
        }

        $this->repository->create($input);

        $this->assignRole($email);
    }
}
