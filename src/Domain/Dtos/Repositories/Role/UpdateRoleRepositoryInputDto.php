<?php

namespace Src\Domain\Dtos\Repositories\Role;

class UpdateRoleRepositoryInputDto
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
