<?php

namespace Src\Application\Repositories;

use Src\Application\Dtos\Repositories\Role\{SyncPermissionsRoleRepositoryDto};
use Src\Application\Dtos\Repositories\Role\CreateRoleRepositoryInputDto;
use Src\Application\Dtos\Repositories\Role\UnsyncPermissionsRoleRepositoryDto;
use Src\Application\Dtos\Repositories\Role\UpdateRoleRepositoryInputDto;
use stdClass;

interface RoleRepositoryInterface
{
    public function create(CreateRoleRepositoryInputDto $input): stdClass;

    public function find(int $id): ?stdClass;

    public function findByName(string $name, string $guardName): ?stdClass;

    public function update(UpdateRoleRepositoryInputDto $input, int $id): bool;

    public function findAll(): array;

    public function delete(int $id): bool;

    public function syncPermissions(SyncPermissionsRoleRepositoryDto $input): bool;

    public function unsyncPermissions(UnsyncPermissionsRoleRepositoryDto $input): bool;
}
