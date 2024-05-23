<?php

namespace Src\Application\Dtos\UseCases\Permission\Update;

class UpdatePermissionUseCaseInputDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {
    }
}
