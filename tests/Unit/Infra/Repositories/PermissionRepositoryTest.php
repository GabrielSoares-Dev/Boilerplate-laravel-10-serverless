<?php

namespace Tests\Unit;

use Mockery;
use Spatie\Permission\Models\Permission;
use Src\Infra\Repositories\PermissionRepository\PermissionEloquentRepository;
use Tests\TestCase;

class PermissionRepositoryTest extends TestCase
{
    public function test_should_create(): void
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

        $repository = new PermissionEloquentRepository($mockModel);

        $output = $repository->create($input);

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }

    public function test_should_find(): void
    {
        $mockModel = Mockery::mock(Permission::class);
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

        $repository = new PermissionEloquentRepository($mockModel);

        $id = 1;
        $output = $repository->find($id);

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

        $repository = new PermissionEloquentRepository($mockModel);

        $output = $repository->findByName($input);

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

        $repository = new PermissionEloquentRepository($mockModel);

        $output = $repository->findAll();

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }

    public function test_should_update(): void
    {
        $mockModel = Mockery::mock(Permission::class);

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('update')
            ->andReturn(true);

        $repository = new PermissionEloquentRepository($mockModel);

        $id = 1;
        $input = [
            'name' => 'test',
        ];
        $output = $repository->update($input, $id);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }

    public function test_should_delete(): void
    {
        $mockModel = Mockery::mock(Permission::class);

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();
        $mockModel
            ->shouldReceive('delete')
            ->andReturn(true);

        $repository = new PermissionEloquentRepository($mockModel);

        $id = 1;
        $output = $repository->delete($id);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }
}
