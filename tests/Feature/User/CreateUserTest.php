<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Infra\Models\User;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/user';

    public function test_user_created(): void
    {
        $this->seed();
        $input = [
            'name' => 'Boilerplate',
            'email' => 'boilerplate@gmail.com',
            'phone_number' => '11942421224',
            'password' => 'Boilerplate@2023',
        ];
        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 201,
            'message' => 'User created successfully',
        ];

        $output->assertStatus(201);
        $output->assertJson($expectedOutput);
    }

    public function test_user_already_exists(): void
    {
        $createdUser = User::factory()->create();
        $input = [
            'name' => 'Boilerplate',
            'email' => $createdUser->email,
            'phone_number' => '11942421224',
            'password' => 'Boilerplate@2023',
        ];
        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'User already exists',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_user_empty_fields(): void
    {

        $output = $this->post($this->path);

        $expectedOutput = [
            'errors' => [
                'name' => [
                    'The name field is required.',
                ],
                'email' => [
                    'The email field is required.',
                ],
                'phone_number' => [
                    'The phone number field is required.',
                ],
                'password' => [
                    'The password field is required.',
                ],
            ],
        ];

        $output->assertStatus(422);
        $output->assertJson($expectedOutput);
    }
}
