<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Domain\Enums\Role as RoleEnum;
use Src\Infra\Models\User;

class UserSeeder extends Seeder
{
    private function admin()
    {
        $email = 'admin@gmail.com';

        $input = [
            'name' => 'admin',
            'email' => $email,
            'phone_number' => 11942421224,
            'password' => 'admin@1234',
        ];

        $alreadyExist = User::where('email', $email)->first();

        if (!$alreadyExist) User::create($input)->assignRole(RoleEnum::ADMIN);
    }

    public function run(): void
    {
        $this->admin();
    }
}
