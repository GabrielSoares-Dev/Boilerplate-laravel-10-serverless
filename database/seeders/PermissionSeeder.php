<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Src\Domain\Enums\Permission as PermissionEnum;

class PermissionSeeder extends Seeder
{
    protected string $defaultGuardName = 'api';

    public function run(): void
    {

        $permissions = [
            PermissionEnum::CREATE_PERMISSION,
            PermissionEnum::READ_ALL_PERMISSIONS,
            PermissionEnum::DELETE_PERMISSION,
            PermissionEnum::READ_PERMISSION,
            PermissionEnum::UPDATE_PERMISSION,
            PermissionEnum::CREATE_ROLE,
            PermissionEnum::READ_ALL_ROLES,
            PermissionEnum::DELETE_ROLE,
            PermissionEnum::READ_ROLE,
            PermissionEnum::UPDATE_ROLE,
            PermissionEnum::SYNC_ROLE_WITH_PERMISSIONS,
            PermissionEnum::UNSYNC_ROLE_WITH_PERMISSIONS,

        ];

        foreach ($permissions as $permission) Permission::findOrCreate($permission, $this->defaultGuardName);

    }
}
