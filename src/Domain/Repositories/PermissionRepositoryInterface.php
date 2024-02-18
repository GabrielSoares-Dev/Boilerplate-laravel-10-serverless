<?php

namespace Src\Domain\Repositories;

use Src\Domain\Dtos\Repositories\Permission\CreatePermissionRepositoryInputDto;
use Src\Domain\Dtos\Repositories\Permission\UpdatePermissionInputDto;
use stdClass;

interface PermissionRepositoryInterface
{
    public function create(CreatePermissionRepositoryInputDto $input): stdClass;

    public function findByName(string $name, string $guardName): ?stdClass;

    public function find(int $id): ?stdClass;

    public function update(UpdatePermissionInputDto $input, int $id): ?stdClass;

    public function findAll(): array;

    public function delete(int $id): void;
}
