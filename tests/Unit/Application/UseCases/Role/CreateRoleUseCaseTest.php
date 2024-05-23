<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Dtos\UseCases\Role\Create\CreateRoleUseCaseInputDto;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\UseCases\Role\CreateRoleUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class CreateRoleUseCaseTest extends TestCase
{
    public function test_should_create(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $input = new CreateRoleUseCaseInputDto('admin');

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn(null);

        $repositoryMock
            ->shouldReceive('create')
            ->andReturn((object) []);

        $useCase = new CreateRoleUseCase($loggerMock, $repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_already_exists(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $mockFindByName = (object) [
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $input = new CreateRoleUseCaseInputDto('admin');

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindByName);

        $useCase = new CreateRoleUseCase($loggerMock, $repositoryMock);

        $this->expectExceptionMessage('Role already exists');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
