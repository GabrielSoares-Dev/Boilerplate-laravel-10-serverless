<?php

namespace Src\Domain\Dtos\Repositories\Permission;

class UpdatePermissionRepositoryInputDto
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
