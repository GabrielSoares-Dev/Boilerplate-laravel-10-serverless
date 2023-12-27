<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DeletePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/permission';

    public function test_deleted(): void
    {

        $permission = Permission::create(['name' => 'test', 'guard_name' => 'api']);

        $id = $permission->id;
        $output = $this->delete("$this->path/$id");

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
        $output = $this->delete("$this->path/$id");

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid id',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }
}
