<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;
use Src\Application\Dtos\Entities\Role\RoleEntityDto;

class Role
{
    public function __construct(private readonly RoleEntityDto $input) {}

    private function validateName(): bool
    {
        return !empty($this->input->name);
    }

    public function create(): void
    {
        if (!$this->validateName())  throw new BusinessException('Invalid name');
    }

    public function update(): void
    {
        if (!$this->validateName())  throw new BusinessException('Invalid name');
    }
}
