<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\Mocks\LoggerMock;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Domain\Dtos\UseCases\Permission\Create\CreatePermissionUseCaseInputDto;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class CreatePermissionUseCaseTest extends TestCase
{
    public function test_should_create(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $input = new CreatePermissionUseCaseInputDto('create_permission');

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn(null);

        $repositoryMock
            ->shouldReceive('create')
            ->andReturn((object) []);

        $useCase = new CreatePermissionUseCase($loggerMock, $repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_already_exists(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFindByName = (object) [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $input = new CreatePermissionUseCaseInputDto('create_permission');

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindByName);

        $useCase = new CreatePermissionUseCase($loggerMock, $repositoryMock);

        $this->expectExceptionMessage('Permission already exists');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
