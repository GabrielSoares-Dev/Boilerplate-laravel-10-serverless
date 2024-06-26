<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Dtos\UseCases\Role\SyncPermissionsWithRole\SyncPermissionsWithRoleUseCaseInputDto;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\UseCases\Role\SyncPermissionsWithRoleUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class SyncPermissionsWithRoleUseCaseTest extends TestCase
{
    public function test_should_sync(): void
    {
        $loggerMock = LoggerMock::mock();

        $roleRepositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $permissionRepositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFindPermissionByNameOutput = (object) [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $permissionRepositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindPermissionByNameOutput);

        $mockFindRoleByNameOutput = (object) [
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

        $role = 'admin';
        $permissions = ['create_permission'];
        $input = new SyncPermissionsWithRoleUseCaseInputDto($role, $permissions);

        $useCase = new SyncPermissionsWithRoleUseCase($loggerMock, $roleRepositoryMock, $permissionRepositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_some_invalid_permission(): void
    {
        $loggerMock = LoggerMock::mock();

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

        $role = 'admin';
        $permissions = ['create_permission'];
        $input = new SyncPermissionsWithRoleUseCaseInputDto($role, $permissions);

        $useCase = new SyncPermissionsWithRoleUseCase($loggerMock, $roleRepositoryMock, $permissionRepositoryMock);

        $this->expectExceptionMessage('Invalid permission');

        $useCase->run($input);
    }

    public function test_should_role_invalid(): void
    {
        $loggerMock = LoggerMock::mock();

        $roleRepositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $permissionRepositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFindPermissionByNameOutput = (object) [
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

        $role = 'admin';
        $permissions = ['create_permission'];
        $input = new SyncPermissionsWithRoleUseCaseInputDto($role, $permissions);

        $useCase = new SyncPermissionsWithRoleUseCase($loggerMock, $roleRepositoryMock, $permissionRepositoryMock);

        $this->expectExceptionMessage('Invalid role');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
