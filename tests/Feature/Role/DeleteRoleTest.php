<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleted(): void
    {

        $role = Role::create(['name' => 'test', 'guard_name' => 'api']);

        $id = $role->id;
        $output = $this->delete("/v1/role/$id");

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Role deleted successfully',
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {

        $id = 300;
        $output = $this->delete("/v1/role/$id");

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid id',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }
}
