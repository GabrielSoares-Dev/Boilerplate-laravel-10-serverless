<?php

namespace Src\Application\UseCases\User;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Entities\User;
use Src\Domain\Enums\Role;
use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Domain\Dtos\UseCases\User\CreateUserUseCaseInputDto;
use Src\Domain\Dtos\Repositories\User\{
    CreateUserRepositoryInputDto,
    AssignRoleRepositoryInputDto
};

class CreateUserUseCase
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(CreateUserUseCaseInputDto $input): void
    {
        $entity = new User(...(array) $input);

        $entity->create();
    }

    protected function foundUserBySameEmail(string $email): bool
    {
        return (bool) $this->repository->findByEmail($email);
    }

    protected function assignRole(string $email): void
    {
        $input = new AssignRoleRepositoryInputDto(Role::ADMIN, $email);

        $this->repository->assignRole($input);
    }

    public function run(CreateUserUseCaseInputDto $input): void
    {

        $this->valid($input);

        $email = $input->email;

        if ($this->foundUserBySameEmail($email)) throw new BusinessException('User already exists');

        $data = new CreateUserRepositoryInputDto(...(array) $input);

        $this->repository->create($data);

        $this->assignRole($email);
    }
}
