<?php

namespace Src\Domain\Dtos\UseCases\Role\Find;

class FindRoleUseCaseInputDto
{
    public function __construct(public readonly int $id)
    {
    }
}
