<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\Helpers\Mocks\AuthorizeMock;
use Tests\TestCase;

class FindRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/role';

    protected $permission = 'read_role';

    public function test_find(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        $role = Role::create(['name' => 'test', 'guard_name' => 'api', 'created_at' => '2023-12-23 20:23:11', 'updated_at' => '2023-12-23 20:23:11']);

        $id = $role->id;
        $output = $this->get("$this->path/$id");

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Role found',
            'content' => [
                'id' => 1,
                'name' => 'test',
                'guard_name' => 'api',
                'created_at' => '2023-12-23T20:23:11.000000Z',
                'updated_at' => '2023-12-23T20:23:11.000000Z',

            ],
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        $id = 300;
        $output = $this->get("$this->path/$id");

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid id',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_not_have_permission(): void
    {
        AuthorizeMock::notHavePermissionMock();
        $this->withoutMiddleware();

        $id = 300;
        $output = $this->get("$this->path/$id");

        $expectedOutput = [
            'statusCode' => 403,
            'message' => 'Access to this resource was denied',
        ];

        $output->assertStatus(403);
        $output->assertJson($expectedOutput);
    }
}
