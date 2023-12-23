<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreatePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permission_created(): void
    {

        $input = [
            'name' => 'test',
        ];
        $output = $this->post('/v1/permission', $input);

        $expectedOutput = [
            'statusCode' => 201,
            'message' => 'Permission created successfully',
        ];

        $output->assertStatus(201);
        $output->assertJson($expectedOutput);
    }

    public function test_permission_already_exists(): void
    {
        Permission::create(['name' => 'test', 'guard_name' => 'api']);

        $input = [
            'name' => 'test',
        ];
        $output = $this->post('/v1/permission', $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Permission already exists',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_permission_empty_fields(): void
    {

        $output = $this->post('/v1/permission');

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
