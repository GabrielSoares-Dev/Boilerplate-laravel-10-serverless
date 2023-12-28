<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Src\Domain\Enums\Role as RoleEnum;

class RoleWithPermissionsSeeder extends Seeder
{
    protected function adminRole()
    {
        $permissions = [
            'create_permission',
            'read_all_permissions',
            'delete_permission',
            'read_permission',
            'update_permission',
            'create_role',
            'read_all_roles',
            'delete_role',
            'read_role',
            'update_role',
            'sync_role_with_permissions',
            'unsync_role_with_permissions',
        ];

        $role = Role::findByName(RoleEnum::ADMIN);

        $role->syncPermissions($permissions);
    }

    public function run(): void
    {
        $this->adminRole();
    }
}
