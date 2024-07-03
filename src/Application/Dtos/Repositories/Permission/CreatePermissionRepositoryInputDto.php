<?php

namespace Src\Application\Dtos\Repositories\Permission;

class CreatePermissionRepositoryInputDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $guardName,
    ) {}
}
