<?php

namespace Src\Domain\Dtos\UseCases\Role\Find;

class FindRoleUseCaseOutputDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $guard_name,
        public readonly string $created_at,
        public readonly string $updated_at
    ) {
    }
}
