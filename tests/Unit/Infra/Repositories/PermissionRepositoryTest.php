<?php

namespace Tests\Unit;

use Mockery;
use Spatie\Permission\Models\Permission;
use Src\Infra\Repositories\PermissionRepository\PermissionEloquentRepository;
use Tests\TestCase;

class PermissionRepositoryTest extends TestCase
{
    public function test_should_create_new_permission(): void
    {
        $mockModel = Mockery::mock(Permission::class);

        $input = [
            'name' => 'create_permission',
        ];

        $expectedOutput = [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
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

    public function test_should_find_by_name(): void
    {
        $mockModel = Mockery::mock(Permission::class);

        $input = [
            'name' => 'create_permission',
            'guard_name' => 'api',
        ];

        $expectedOutput = [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('first')
            ->andReturn($expectedOutput);

        $permissionRepository = new PermissionEloquentRepository($mockModel);

        $output = $permissionRepository->findByName($input);

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }

    public function test_should_find_all(): void
    {
        $mockModel = Mockery::mock(Permission::class);

        $expectedOutput = [
            [
                'id' => 1,
                'name' => 'create_permission',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
            [
                'id' => 2,
                'name' => 'delete_permission',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
        ];

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('get')
            ->andReturn($expectedOutput);

        $permissionRepository = new PermissionEloquentRepository($mockModel);

        $output = $permissionRepository->findAll();

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }
}
