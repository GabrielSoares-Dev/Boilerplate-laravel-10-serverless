<?php

namespace Src\Application\Dtos\Repositories\Role;

class UpdateRoleRepositoryInputDto
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
