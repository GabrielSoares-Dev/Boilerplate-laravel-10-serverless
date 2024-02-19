<?php

namespace Src\Domain\Dtos\Repositories\Role;

class CreateRoleRepositoryInputDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $guardName,
    ) {
    }
}
