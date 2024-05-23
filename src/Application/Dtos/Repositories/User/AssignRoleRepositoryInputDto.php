<?php

namespace Src\Application\Dtos\Repositories\User;

class AssignRoleRepositoryInputDto
{
    public function __construct(
        public readonly string $role,
        public readonly string $email
    ) {
    }
}
