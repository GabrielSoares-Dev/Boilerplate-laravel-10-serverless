<?php

namespace Src\Domain\Repositories;

use stdClass;
use Src\Domain\Dtos\Repositories\Role\{
    CreateRoleRepositoryInputDto
};

interface RoleRepositoryInterface
{
    public function create(CreateRoleRepositoryInputDto $input): stdClass;

    public function find(int $id): ?stdClass;

    public function findByName(string $name, string $guardName): ?stdClass;

    public function update(array $input, string $id);

    public function findAll();

    public function delete(string $id);

    public function syncPermissions(array $input);

    public function unsyncPermissions(array $input);
}
