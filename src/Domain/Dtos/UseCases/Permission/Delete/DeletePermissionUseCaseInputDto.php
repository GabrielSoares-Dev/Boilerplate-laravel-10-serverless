<?php

namespace Src\Domain\Dtos\UseCases\Permission\Delete;

class DeletePermissionUseCaseInputDto
{
    public function __construct(public readonly int $id)
    {
    }
}
