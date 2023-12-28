<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\Helpers\Mocks\AuthorizeMock;
use Tests\TestCase;

class SyncPermissionsWithRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/role/sync-permissions';

    protected $permission = 'sync_role_with_permissions';

    public function test_sync(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Permission::create(['name' => 'create_permission', 'guard_name' => 'api']);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Role sync successfully',
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_permission(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid permission',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_role(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        Permission::create(['name' => 'create_permission', 'guard_name' => 'api']);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid role',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        $output = $this->post($this->path);

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

    public function test_not_have_permission(): void
    {
        AuthorizeMock::notHavePermissionMock();
        $this->withoutMiddleware();

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 403,
            'message' => 'Access to this resource was denied',
        ];

        $output->assertStatus(403);
        $output->assertJson($expectedOutput);
    }
}
