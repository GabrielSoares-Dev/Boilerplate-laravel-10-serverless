<?php

namespace Src\Application\Dtos\Repositories\Role;

class CreateRoleRepositoryInputDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $guardName,
    ) {
    }
}
