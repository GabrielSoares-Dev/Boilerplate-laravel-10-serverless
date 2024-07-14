<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Role;
use Tests\AuthenticatedTestCase;

class DeletePermissionTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private $path = '/v1/permission';

    protected $role = Role::ADMIN;

    public function test_deleted(): void
    {
        $permission = Permission::create(['name' => 'test', 'guard_name' => 'api']);

        $id = $permission->id;
        $output = $this->delete("$this->path/$id", [], $this->headers);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Permission deleted successfully',
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {
        $id = 300;
        $output = $this->delete("$this->path/$id", [], $this->headers);

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
        $output = $this->delete("$this->path/$id");

        $expectedOutput = [
            'statusCode' => 403,
            'message' => 'Access to this resource was denied',
        ];

        $output->assertStatus(403);
        $output->assertJson($expectedOutput);
    }
}
