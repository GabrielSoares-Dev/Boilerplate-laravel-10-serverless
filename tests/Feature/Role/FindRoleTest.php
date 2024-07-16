<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Role as RoleEnum;
use Tests\AuthenticatedTestCase;

class FindRoleTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private $path = '/v1/role';

    protected $role = RoleEnum::ADMIN;

    public function test_find(): void
    {
        $role = Role::create(['name' => 'test', 'guard_name' => 'api', 'created_at' => '2023-12-23 20:23:11', 'updated_at' => '2023-12-23 20:23:11']);

        $id = $role->id;
        $output = $this->get("$this->path/$id", $this->headers);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Role found',
            'content' => [
                'id' => $id,
                'name' => 'test',
                'createdAt' => '2023-12-23T20:23:11.000000Z',
                'updatedAt' => '2023-12-23T20:23:11.000000Z',

            ],
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {
        $id = 300;
        $output = $this->get("$this->path/$id", $this->headers);

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
