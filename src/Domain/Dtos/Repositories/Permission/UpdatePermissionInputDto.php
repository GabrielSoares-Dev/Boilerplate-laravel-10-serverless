<?php

namespace Src\Domain\Dtos\Repositories\Permission;

class UpdatePermissionInputDto
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
