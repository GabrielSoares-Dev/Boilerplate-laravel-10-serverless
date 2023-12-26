<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SyncPermissionsWithRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync(): void
    {

        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Permission::create(['name' => 'create_permission', 'guard_name' => 'api']);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post('/v1/role/sync-permissions', $input);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Role sync successfully',
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_permission(): void
    {
        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post('/v1/role/sync-permissions', $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid permission',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_role(): void
    {
        Permission::create(['name' => 'create_permission', 'guard_name' => 'api']);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post('/v1/role/sync-permissions', $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid role',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {
        $output = $this->post('/v1/role/sync-permissions');

        $expectedOutput = [
            'errors' => [
                'role' => [
                    'The role field is required.',
                ],
                'permissions' => [
                    'The permissions field is required.',
                ],
            ],
        ];

        $output->assertStatus(422);
        $output->assertJson($expectedOutput);
    }
}
