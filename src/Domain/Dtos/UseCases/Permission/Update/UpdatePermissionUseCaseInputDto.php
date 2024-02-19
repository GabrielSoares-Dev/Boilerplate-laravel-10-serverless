<?php

namespace Src\Domain\Dtos\UseCases\Permission\Update;

class UpdatePermissionUseCaseInputDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {
    }
}
