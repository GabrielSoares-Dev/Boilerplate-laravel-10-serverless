<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\Helpers\Mocks\AuthorizeMock;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/role';

    protected $permission = 'create_role';

    public function test_created(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();

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
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
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
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
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

    public function test_not_have_permission(): void
    {
        AuthorizeMock::notHavePermissionMock();
        $this->withoutMiddleware();

        $input = [
            'name' => 'test',
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
