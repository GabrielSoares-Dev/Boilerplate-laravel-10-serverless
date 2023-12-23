<?php

namespace Tests\Unit;

use Src\Infra\Repositories\PermissionRepository\PermissionEloquentRepository;
use Mockery;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionRepositoryTest extends TestCase
{
    public function test_should_create_new_permission(): void
    {
        $mockModel = Mockery::mock(Permission::class);

        $input = [
            'name' => 'ADMIN',
        ];

        $expectedOutput = [
            'id' => 1,
            'name' => 'ADMIN',
            'guard_name' => null,
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $mockModel
            ->shouldReceive('create')
            ->with($input)
            ->andReturn($expectedOutput);

        $permissionRepository = new PermissionEloquentRepository($mockModel);

        $output = $permissionRepository->create($input);

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }
}
