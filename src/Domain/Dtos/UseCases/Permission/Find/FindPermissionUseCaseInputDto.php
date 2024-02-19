<?php

namespace Src\Domain\Dtos\UseCases\Permission\Find;

class FindPermissionUseCaseInputDto
{
    public function __construct(public readonly int $id)
    {
    }
}
