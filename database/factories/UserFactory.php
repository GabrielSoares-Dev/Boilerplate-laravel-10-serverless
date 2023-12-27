<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Src\Infra\Models\User;

class UserFactory extends Factory
{
    protected static ?string $password;

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),

        ];
    }
}
