<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\Mocks\LoggerMock;
use Src\Application\UseCases\Role\UnsyncPermissionsWithRoleUseCase;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\UnsyncPermissionsWithRole\UnsyncPermissionsWithRoleUseCaseInputDto;

class UnsyncPermissionsWithRoleUseCaseTest extends TestCase
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
            ->shouldReceive('unsyncPermissions')
            ->andReturn(true);

        $role = 'admin';

        $permissions = ['create_permission'];

        $input = new UnsyncPermissionsWithRoleUseCaseInputDto($role, $permissions);

        $useCase = new UnsyncPermissionsWithRoleUseCase($loggerMock, $roleRepositoryMock, $permissionRepositoryMock);

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
            ->shouldReceive('unsyncPermissions')
            ->andReturn(false);

        $role = 'admin';

        $permissions = ['create_permission'];

        $input = new UnsyncPermissionsWithRoleUseCaseInputDto($role, $permissions);

        $useCase = new UnsyncPermissionsWithRoleUseCase($loggerMock, $roleRepositoryMock, $permissionRepositoryMock);

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
            ->shouldReceive('unsyncPermissions')
            ->andReturn(false);

        $role = 'admin';

        $permissions = ['create_permission'];

        $input = new UnsyncPermissionsWithRoleUseCaseInputDto($role, $permissions);

        $useCase = new UnsyncPermissionsWithRoleUseCase($loggerMock, $roleRepositoryMock, $permissionRepositoryMock);

        $this->expectExceptionMessage('Invalid role');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
