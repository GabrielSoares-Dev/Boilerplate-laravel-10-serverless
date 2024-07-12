<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Permission as PermissionEnum;
use Tests\TestCase;

class CreatePermissionTest extends TestCase
{
    use RefreshDatabase;

    private $path = '/v1/permission';

    private $permission = PermissionEnum::CREATE_PERMISSION;

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
            'message' => 'Permission created successfully',
        ];

        $output->assertStatus(201);
        $output->assertJson($expectedOutput);
    }

    public function test_already_exists(): void
    {
        AuthorizeMock::hasPermissionMock($this->permission);
        $this->withoutMiddleware();
        Permission::create(['name' => 'test', 'guard_name' => 'api']);

        $input = [
            'name' => 'test',
        ];
        $output = $this->post($this->path, $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Permission already exists',
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
