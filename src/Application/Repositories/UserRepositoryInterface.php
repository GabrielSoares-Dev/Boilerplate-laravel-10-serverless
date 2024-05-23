<?php

namespace Src\Application\Repositories;

use Src\Application\Dtos\Repositories\User\{CreateUserRepositoryInputDto};
use Src\Application\Dtos\Repositories\User\AssignRoleRepositoryInputDto;
use stdClass;

interface UserRepositoryInterface
{
    public function create(CreateUserRepositoryInputDto $input): stdClass;

    public function findByEmail(string $email): ?stdClass;

    public function assignRole(AssignRoleRepositoryInputDto $input): bool;
}
