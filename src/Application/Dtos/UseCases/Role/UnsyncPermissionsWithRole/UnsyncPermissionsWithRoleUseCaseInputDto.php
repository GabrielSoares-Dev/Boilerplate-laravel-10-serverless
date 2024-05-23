<?php

namespace Src\Application\Dtos\UseCases\Role\UnsyncPermissionsWithRole;

class UnsyncPermissionsWithRoleUseCaseInputDto
{
    public function __construct(
        public readonly string $role,
        public readonly array $permissions
    ) {
    }
}
