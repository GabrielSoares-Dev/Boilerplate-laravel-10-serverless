<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;

class Permission
{
    private ?string $name;

    private ?string $guardName;

    public function create(array $input)
    {
        $nameIsEmpty = empty($input['name']);
        $guardNameIsEmpty = empty($input['guard_name']);

        if ($nameIsEmpty) {
            throw new BusinessException('Invalid name');
        }

        if ($guardNameIsEmpty) {
            throw new BusinessException('Invalid guard name');
        }

        $this->name = $input['name'];
        $this->guardName = $input['guard_name'];

        return $this->toArray();
    }

    protected function toArray()
    {
        return [
            'name' => $this->name,
            'guard_name' => $this->guardName,
        ];
    }
}
