<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Permission as PermissionEnum;
use Tests\TestCase;

class FindAllRolesTest extends TestCase
{
    use RefreshDatabase;

    private $path = '/v1/role';

    private $permission = PermissionEnum::READ_ALL_ROLES;

    public function test_found(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        Role::create(['name' => 'test', 'guard_name' => 'api', 'created_at' => '2023-12-23 20:23:11', 'updated_at' => '2023-12-23 20:23:11']);

        $output = $this->get($this->path);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Found roles',
            'content' => [
                [
                    'id' => 1,
                    'name' => 'test',
                    'guard_name' => 'api',
                    'created_at' => '2023-12-23T20:23:11.000000Z',
                    'updated_at' => '2023-12-23T20:23:11.000000Z',
                ],
            ],
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_not_have_permission(): void
    {
        AuthorizeMock::notHavePermissionMock();
        $this->withoutMiddleware();

        $output = $this->get($this->path);

        $expectedOutput = [
            'statusCode' => 403,
            'message' => 'Access to this resource was denied',
        ];

        $output->assertStatus(403);
        $output->assertJson($expectedOutput);
    }
}
