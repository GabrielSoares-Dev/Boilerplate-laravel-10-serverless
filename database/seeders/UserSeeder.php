<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Domain\Enums\Role as RoleEnum;
use Src\Infra\Models\User;

class UserSeeder extends Seeder
{
    protected function admin()
    {

        $input = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => 11942421224,
            'password' => 'admin@1234',
        ];

        User::create($input)->assignRole(RoleEnum::ADMIN);
    }

    public function run(): void
    {
        $this->admin();
    }
}
