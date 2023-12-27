<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/role';

    public function test_created(): void
    {

        $input = [
            'name' => 'test',
        ];
        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 201,
            'message' => 'Role created successfully',
        ];

        $output->assertStatus(201);
        $output->assertJson($expectedOutput);
    }

    public function test_already_exists(): void
    {
        Role::create(['name' => 'test', 'guard_name' => 'api']);

        $input = [
            'name' => 'test',
        ];
        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Role already exists',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {

        $output = $this->post($this->path);

        $expectedOutput = [
            'errors' => [
                'name' => [
                    'The name field is required.',
                ],
            ],
        ];

        $output->assertStatus(422);
        $output->assertJson($expectedOutput);
    }
}
