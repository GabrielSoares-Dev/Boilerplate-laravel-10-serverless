<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Src\Domain\Enums\Role as RoleEnum;
use Src\Domain\Enums\Permission as PermissionEnum;

class RoleWithPermissionsSeeder extends Seeder
{
    private function adminRole()
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
        $role = Role::findByName(RoleEnum::ADMIN);

        foreach ($permissions as $permission) {

            $alreadySync = $role->hasPermissionTo($permission);

            if (!$alreadySync) $role->givePermissionTo($permission);
        }
    }

    public function run(): void
    {
        $this->adminRole();
    }
}
