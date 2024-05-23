<?php

namespace Src\Application\Dtos\UseCases\Permission\Find;

class FindPermissionUseCaseInputDto
{
    public function __construct(public readonly int $id)
    {
    }
}
