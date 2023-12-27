<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;

class Role
{
    protected ?string $name;

    protected ?string $guardName;

    public function create(array $input)
    {
        $nameIsEmpty = empty($input['name']);
        $guardNameIsInvalid = $input['guard_name'] !== 'api';

        if ($nameIsEmpty) {
            throw new BusinessException('Invalid name');
        }

        if ($guardNameIsInvalid) {
            throw new BusinessException('Invalid guard name');
        }

        $this->name = $input['name'];
        $this->guardName = $input['guard_name'];

        return $this->toArray();
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
