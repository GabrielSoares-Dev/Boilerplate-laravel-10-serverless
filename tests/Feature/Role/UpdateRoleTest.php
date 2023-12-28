<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/v1/role';

    public function test_updated(): void
    {
        $this->withoutMiddleware();
        $role = Role::create(['name' => 'test', 'guard_name' => 'api']);

        $id = $role->id;
        $input = [
            'name' => 'new name',
        ];
        $output = $this->put("$this->path/$id", $input);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Role Updated successfully',
        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }

    public function test_invalid_id(): void
    {
        $this->withoutMiddleware();
        $id = 300;
        $input = [
            'name' => 'new name',
        ];
        $output = $this->put("$this->path/$id", $input);

        $expectedOutput = [
            'statusCode' => 400,
            'message' => 'Invalid id',
        ];

        $output->assertStatus(400);
        $output->assertJson($expectedOutput);
    }

    public function test_empty_fields(): void
    {
        $this->withoutMiddleware();
        $id = 300;
        $output = $this->put("$this->path/$id");

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
}
