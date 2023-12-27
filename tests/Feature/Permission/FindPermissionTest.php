<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class FindPermissionTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/permission';

    public function test_find(): void
    {

        $permission = Permission::create(['name' => 'test', 'guard_name' => 'api', 'created_at' => '2023-12-23 20:23:11', 'updated_at' => '2023-12-23 20:23:11']);

        $id = $permission->id;
        $output = $this->get("$this->path/$id");

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Permission found',
            'content' => [
                'id' => 1,
                'name' => 'test',
                'guard_name' => 'api',
                'created_at' => '2023-12-23T20:23:11.000000Z',
                'updated_at' => '2023-12-23T20:23:11.000000Z',

            ],
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {

        $id = 300;
        $output = $this->get("$this->path/$id");

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid id',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }
}
