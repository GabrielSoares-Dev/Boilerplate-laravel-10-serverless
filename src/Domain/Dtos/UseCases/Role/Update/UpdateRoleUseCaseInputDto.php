<?php

namespace Src\Domain\Dtos\UseCases\Role\Update;

class UpdateRoleUseCaseInputDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {
    }
}
