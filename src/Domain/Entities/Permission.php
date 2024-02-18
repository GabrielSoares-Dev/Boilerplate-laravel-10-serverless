<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;

class Permission
{
    protected ?string $name;

    protected ?string $guardName;

    public function create(string $name, string $guardName): void
    {
        $nameIsEmpty = empty($name);
        $guardNameIsInvalid = $guardName !== 'api';

        if ($nameIsEmpty) {
            throw new BusinessException('Invalid name');
        }

        if ($guardNameIsInvalid) {
            throw new BusinessException('Invalid guard name');
        }
    }

    public function update(array $input)
    {
        $nameIsEmpty = empty($input['name']);
        $guardNameIsInvalid = $input['guard_name'] !== 'api';

        if ($nameIsEmpty) {
            throw new BusinessException('Invalid name');
        }

        if ($guardNameIsInvalid) {
            throw new BusinessException('Invalid guard name');
        }
    }
}
