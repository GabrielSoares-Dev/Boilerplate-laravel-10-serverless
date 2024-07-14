<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Role as RoleEnum;
use Tests\AuthenticatedTestCase;

class SyncPermissionsWithRoleTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private $path = '/v1/role/sync-permissions';

    private $input = [
        'role' => 'admin',
        'permissions' => ['create_permission'],
    ];

    protected $role = RoleEnum::ADMIN;

    public function test_sync(): void
    {
        $output = $this->post($this->path, $this->input, $this->headers);

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
            'permissions' => ['test'],
        ];
        $output = $this->post($this->path, $input, $this->headers);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid permission',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_role(): void
    {
        $input = [
            'role' => 'test',
            'permissions' => ['create_permission'],
        ];

        $output = $this->post($this->path, $input, $this->headers);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid role',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {
        $output = $this->post($this->path, [], $this->headers);

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
