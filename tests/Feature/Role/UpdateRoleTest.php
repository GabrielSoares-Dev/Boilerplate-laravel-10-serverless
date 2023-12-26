<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_updated(): void
    {

        $role = Role::create(['name' => 'test', 'guard_name' => 'api']);

        $id = $role->id;
        $input = [
            'name' => 'new name',
        ];
        $output = $this->put("/v1/role/$id", $input);

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
        $input = [
            'name' => 'new name',
        ];
        $output = $this->put("/v1/role/$id", $input);

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
        $output = $this->put("/v1/role/$id");

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
