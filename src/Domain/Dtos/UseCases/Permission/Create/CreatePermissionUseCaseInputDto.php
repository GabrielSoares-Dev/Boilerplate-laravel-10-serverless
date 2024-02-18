<?php

namespace Src\Domain\Dtos\UseCases\Permission\Create;

class CreatePermissionUseCaseInputDto
{
    public function __construct(public readonly string $name)
    {
    }
}
