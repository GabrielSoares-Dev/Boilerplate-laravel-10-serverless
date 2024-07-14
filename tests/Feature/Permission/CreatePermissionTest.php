<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Role;
use Tests\AuthenticatedTestCase;

class CreatePermissionTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private $path = '/v1/permission';

    private $input = [
        'name' => 'test',
    ];

    protected $role = Role::ADMIN;

    public function test_created(): void
    {
        $output = $this->post($this->path, $this->input, $this->headers);

        $expectedOutput = [
            'statusCode' => 201,
            'message' => 'Permission created successfully',
        ];

        $output->assertStatus(201);
        $output->assertJson($expectedOutput);
    }

    public function test_already_exists(): void
    {
        Permission::create(['name' => 'test', 'guard_name' => 'api']);

        $output = $this->post($this->path, $this->input, $this->headers);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Permission already exists',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {
        $output = $this->post($this->path, [], $this->headers);

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
