<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Role as RoleEnum;
use Tests\AuthenticatedTestCase;

class UpdateRoleTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private $path = '/v1/role';

    private $input = [
        'name' => 'new name',
    ];

    protected $role = RoleEnum::ADMIN;

    public function test_updated(): void
    {
        $role = Role::create(['name' => 'test', 'guard_name' => 'api']);

        $id = $role->id;

        $output = $this->put("$this->path/$id", $this->input, $this->headers);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Role Updated successfully',
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {
        $id = 300;
        $output = $this->put("$this->path/$id", $this->input, $this->headers);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid id',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {
        $id = 300;
        $output = $this->put("$this->path/$id", [], $this->headers);

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

        $id = 300;
        $output = $this->put("$this->path/$id", $this->input);

        $expectedOutput = [
            'statusCode' => 403,
            'message' => 'Access to this resource was denied',
        ];

        $output->assertStatus(403);
        $output->assertJson($expectedOutput);
    }
}
