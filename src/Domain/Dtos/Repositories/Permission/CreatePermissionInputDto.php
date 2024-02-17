<?php

namespace Src\Domain\Dtos\Repositories\Permission;

class CreatePermissionInputDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $guardName,
    ) {
    }
}
