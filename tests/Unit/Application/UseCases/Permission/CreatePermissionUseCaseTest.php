<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class CreatePermissionUseCaseTest extends TestCase
{
    public function test_should_create_new_permission(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $input = [
            'name' => 'create_permission',
        ];

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn(null);

        $repositoryMock
            ->shouldReceive('create')
            ->andReturn($input);

        $useCase = new CreatePermissionUseCase($repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
        Mockery::close();
    }

    public function test_should_permission_already_exists(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFindByName = [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $input = [
            'name' => 'create_permission',
        ];

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindByName);

        $useCase = new CreatePermissionUseCase($repositoryMock);

        $this->expectExceptionMessage('Permission already exists');

        $useCase->run($input);

        Mockery::close();
    }
}
