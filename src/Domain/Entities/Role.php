<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;

class Role
{
    protected ?string $name;

    protected ?string $guardName;

    public function create(string $name, string $guardName): void
    {
        $nameIsEmpty = empty($name);
        $guardNameIsInvalid = $guardName !== 'api';

        if ($nameIsEmpty) throw new BusinessException('Invalid name');

        if ($guardNameIsInvalid) throw new BusinessException('Invalid guard name');
    }

    public function update(string $name, string $guardName): void
    {
        $nameIsEmpty = empty($name);
        $guardNameIsInvalid = $guardName !== 'api';

        if ($nameIsEmpty) throw new BusinessException('Invalid name');

        if ($guardNameIsInvalid) throw new BusinessException('Invalid guard name');

    }
}
