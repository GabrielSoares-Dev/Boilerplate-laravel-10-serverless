<?php

namespace Src\Application\Dtos\UseCases\Role\Update;

class UpdateRoleUseCaseInputDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {
    }
}
