<?php

namespace Src\Application\Dtos\UseCases\Role\Create;

class CreateRoleUseCaseInputDto
{
    public function __construct(public readonly string $name)
    {
    }
}
