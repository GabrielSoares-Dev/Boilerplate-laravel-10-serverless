<?php

namespace Src\Application\Dtos\UseCases\Permission\Find;

class FindPermissionUseCaseOutputDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $guard_name,
        public readonly string $created_at,
        public readonly string $updated_at
    ) {}
}
