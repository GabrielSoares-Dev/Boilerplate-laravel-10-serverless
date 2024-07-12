<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Src\Domain\Enums\Role as RoleEnum;

class RoleSeeder extends Seeder
{
    protected $defaultGuardName = 'api';

    public function run(): void
    {
        $roles = [RoleEnum::ADMIN];

        foreach ($roles as $role) Role::findOrCreate($role, $this->defaultGuardName);
    }
}
