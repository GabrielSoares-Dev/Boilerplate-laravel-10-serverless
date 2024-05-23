<?php

namespace Src\Application\Repositories;

use Src\Application\Dtos\Repositories\Permission\{UpdatePermissionRepositoryInputDto};
use Src\Application\Dtos\Repositories\Permission\CreatePermissionRepositoryInputDto;
use stdClass;

interface PermissionRepositoryInterface
{
    public function create(CreatePermissionRepositoryInputDto $input): stdClass;

    public function findByName(string $name, string $guardName): ?stdClass;

    public function find(int $id): ?stdClass;

    public function update(UpdatePermissionRepositoryInputDto $input, int $id): bool;

    public function findAll(): array;

    public function delete(int $id): bool;
}
