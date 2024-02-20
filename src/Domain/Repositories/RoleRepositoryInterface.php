<?php

namespace Src\Domain\Repositories;

use stdClass;
use Src\Domain\Dtos\Repositories\Role\{
    CreateRoleRepositoryInputDto,
    UpdateRoleRepositoryInputDto,
    SyncPermissionsRoleRepositoryDto,
    UnsyncPermissionsRoleRepositoryDto
};

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
