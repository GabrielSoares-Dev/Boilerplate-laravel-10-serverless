<?php

namespace Src\Domain\Dtos\UseCases\Role\SyncPermissionsWithRole;

class SyncPermissionsWithRoleUseCaseInputDto
{
    public function __construct(
        public readonly string $role,
        public readonly array $permissions
    ) {
    }
}
