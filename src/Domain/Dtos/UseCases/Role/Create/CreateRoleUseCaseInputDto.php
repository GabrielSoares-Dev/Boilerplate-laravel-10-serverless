<?php

namespace Src\Domain\Dtos\UseCases\Role\Create;

class CreateRoleUseCaseInputDto
{
    public function __construct(public readonly string $name)
    {
    }
}
