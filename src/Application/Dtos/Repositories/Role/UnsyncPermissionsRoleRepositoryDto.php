<?php

namespace Src\Application\Dtos\Repositories\Role;

class UnsyncPermissionsRoleRepositoryDto
{
    public function __construct(
        public readonly string $role,
        public readonly array $permissions
    ) {}
}
