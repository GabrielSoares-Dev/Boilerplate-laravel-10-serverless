<?php

namespace Src\Domain\Repositories;

use stdClass;
use Src\Domain\Dtos\Repositories\User\{
    CreateUserRepositoryInputDto,
    AssignRoleRepositoryInputDto
};

interface UserRepositoryInterface
{
    public function create(CreateUserRepositoryInputDto $input): stdClass;

    public function findByEmail(string $email): ?stdClass;

    public function assignRole(AssignRoleRepositoryInputDto $input): bool;
}
