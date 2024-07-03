<?php

namespace Src\Application\Dtos\UseCases\Permission\Delete;

class DeletePermissionUseCaseInputDto
{
    public function __construct(public readonly int $id) {}
}
