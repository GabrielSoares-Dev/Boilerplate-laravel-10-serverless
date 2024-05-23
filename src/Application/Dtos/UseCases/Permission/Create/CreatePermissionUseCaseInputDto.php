<?php

namespace Src\Application\Dtos\UseCases\Permission\Create;

class CreatePermissionUseCaseInputDto
{
    public function __construct(public readonly string $name)
    {
    }
}
