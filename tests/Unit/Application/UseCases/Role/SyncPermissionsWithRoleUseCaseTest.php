<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Role\SyncPermissionsWithRoleUseCase;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;

class SyncPermissionsWithRoleUseCaseTest extends TestCase
{
    public function test_should_sync(): void
    {
        $roleRepositoryMock = Mockery::mock(RoleRepositoryInterface::class);
        $permissionRepositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFindPermissionByNameOutput = [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $permissionRepositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindPermissionByNameOutput);

        $mockFindRoleByNameOutput = [
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $roleRepositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindRoleByNameOutput);

        $roleRepositoryMock
            ->shouldReceive('syncPermissions')
            ->andReturn(true);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];
        $useCase = new SyncPermissionsWithRoleUseCase($roleRepositoryMock, $permissionRepositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
        Mockery::close();
    }

    public function test_should_some_invalid_permission(): void
    {
        $roleRepositoryMock = Mockery::mock(RoleRepositoryInterface::class);
        $permissionRepositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $permissionRepositoryMock
            ->shouldReceive('findByName')
            ->andReturn(null);

        $roleRepositoryMock
            ->shouldReceive('findByName')
            ->andReturn(null);

        $roleRepositoryMock
            ->shouldReceive('syncPermissions')
            ->andReturn(false);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];
        $useCase = new SyncPermissionsWithRoleUseCase($roleRepositoryMock, $permissionRepositoryMock);

        $this->expectExceptionMessage('Invalid permission');

        $useCase->run($input);

        Mockery::close();
    }

    public function test_should_role_invalid(): void
    {
        $roleRepositoryMock = Mockery::mock(RoleRepositoryInterface::class);
        $permissionRepositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFindPermissionByNameOutput = [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $permissionRepositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindPermissionByNameOutput);

        $roleRepositoryMock
            ->shouldReceive('findByName')
            ->andReturn(null);

        $roleRepositoryMock
            ->shouldReceive('syncPermissions')
            ->andReturn(false);

        $input = [
            'role' => 'admin',
            'permissions' => ['create_permission'],
        ];
        $useCase = new SyncPermissionsWithRoleUseCase($roleRepositoryMock, $permissionRepositoryMock);

        $this->expectExceptionMessage('Invalid role');

        $useCase->run($input);

        Mockery::close();
    }
}
