<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UpdatePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permission_deleted(): void
    {

        $permission = Permission::create(['name' => 'test', 'guard_name' => 'api']);

        $id = $permission->id;
        $input = [
            'name' => 'new name',
        ];
        $output = $this->put("/v1/permission/$id", $input);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Permission Updated successfully',
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {

        $id = 300;
        $input = [
            'name' => 'new name',
        ];
        $output = $this->put("/v1/permission/$id", $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid id',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }
}
