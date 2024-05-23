<?php

namespace Src\Application\Dtos\UseCases\Role\Delete;

class DeleteRoleUseCaseInputDto
{
    public function __construct(public readonly int $id)
    {
    }
}
