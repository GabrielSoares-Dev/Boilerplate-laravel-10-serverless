<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\Helpers\Mocks\AuthorizeMock;
use Src\Domain\Enums\Role;
use Tests\AuthenticatedTestCase;
use Src\Infra\Http\Resources\Permission\PermissionResource;

class FindAllPermissionsTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    private $path = '/v1/permission';

    protected $role = Role::ADMIN;

    public function test_found(): void
    {
        $createdPermissions = Permission::all();

        $output = $this->get($this->path, [], $this->headers);
        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Found permissions',
            'content' => PermissionResource::collection($createdPermissions)->response()->getData(true)['data'],
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
