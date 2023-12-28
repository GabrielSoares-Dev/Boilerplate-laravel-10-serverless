<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    protected $defaultGuardName = 'api';

    public function run(): void
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

        foreach ($permissions as $permission) {
            $input = [
                'name' => $permission,
                'guard_name' => $this->defaultGuardName,
            ];

            Permission::create($input);
        }
    }
}
