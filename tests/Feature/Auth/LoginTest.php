<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Infra\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $path = '/v1/auth/login';

    public function test_authenticated(): void
    {

        User::factory()->create(['email' => 'boilerplate@gmail.com', 'password' => 'Boilerplate@2023']);

        $input = [
            'email' => 'boilerplate@gmail.com',
            'password' => 'Boilerplate@2023',
        ];

        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Authenticated',

        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_credentials(): void
    {
        $input = [
            'email' => 'boilerplate@gmail.com',
            'password' => 'Boilerplate@2023',
        ];

        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 401,
            'message' => 'Invalid credentials',
        ];

        $output->assertStatus(401);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {

        $output = $this->post($this->path);

        $expectedOutput = [
            'errors' => [
                'email' => [
                    'The email field is required.',
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
