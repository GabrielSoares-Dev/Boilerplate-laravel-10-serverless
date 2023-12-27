<?php

namespace Tests\Unit;

use Mockery;
use Spatie\Permission\Models\Role;
use Src\Infra\Repositories\RoleRepository\RoleEloquentRepository;
use Tests\TestCase;

class RoleRepositoryTest extends TestCase
{
    public function test_should_create(): void
    {
        $mockModel = Mockery::mock(Role::class);

        $input = [
            'name' => 'admin',
        ];

        $expectedOutput = [
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $mockModel
            ->shouldReceive('create')
            ->with($input)
            ->andReturn($expectedOutput);

        $repository = new RoleEloquentRepository($mockModel);

        $output = $repository->create($input);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_find(): void
    {
        $mockModel = Mockery::mock(Role::class);
        $expectedOutput = [
            'id' => 1,
            'name' => 'admin',
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

        $repository = new RoleEloquentRepository($mockModel);

        $id = 1;
        $output = $repository->find($id);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_find_all(): void
    {
        $mockModel = Mockery::mock(Role::class);

        $expectedOutput = [
            [
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
            [
                'id' => 2,
                'name' => 'operator',
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

        $repository = new RoleEloquentRepository($mockModel);

        $output = $repository->findAll();

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_find_by_name(): void
    {
        $mockModel = Mockery::mock(Role::class);

        $input = [
            'name' => 'admin',
            'guard_name' => 'api',
        ];

        $expectedOutput = [
            'id' => 1,
            'name' => 'admin',
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

        $repository = new RoleEloquentRepository($mockModel);

        $output = $repository->findByName($input);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_delete(): void
    {
        $mockModel = Mockery::mock(Role::class);

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();
        $mockModel
            ->shouldReceive('delete')
            ->andReturn(true);

        $repository = new RoleEloquentRepository($mockModel);

        $id = 1;
        $output = $repository->delete($id);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_update(): void
    {
        $mockModel = Mockery::mock(Role::class);

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('update')
            ->andReturn(true);

        $repository = new RoleEloquentRepository($mockModel);

        $id = 1;
        $input = [
            'name' => 'test',
        ];
        $output = $repository->update($input, $id);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_sync_permissions(): void
    {
        $mockModel = Mockery::mock(Role::class);

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('first')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('syncPermissions')
            ->andReturn(true);

        $repository = new RoleEloquentRepository($mockModel);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];
        $output = $repository->syncPermissions($input);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_unsync_permissions(): void
    {
        $mockModel = Mockery::mock(Role::class);

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('first')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('revokePermissionTo')
            ->andReturn(true);

        $repository = new RoleEloquentRepository($mockModel);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];
        $output = $repository->unsyncPermissions($input);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
