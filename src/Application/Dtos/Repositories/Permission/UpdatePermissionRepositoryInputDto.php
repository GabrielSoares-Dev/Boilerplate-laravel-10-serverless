<?php

namespace Src\Application\Dtos\Repositories\Permission;

class UpdatePermissionRepositoryInputDto
{
    public function __construct(
        public readonly string $name
    ) {}
}
