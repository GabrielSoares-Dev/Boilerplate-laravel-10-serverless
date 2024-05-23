<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Dtos\UseCases\Permission\Find\{FindPermissionUseCaseOutputDto};
use Src\Application\Dtos\UseCases\Permission\Find\FindPermissionUseCaseInputDto;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\UseCases\Permission\FindPermissionUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class FindPermissionUseCaseTest extends TestCase
{
    public function test_should_find(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFind = (object) [
            'id' => 1,
            'name' => 'create_permission',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn($mockFind);

        $input = new FindPermissionUseCaseInputDto(1);

        $useCase = new FindPermissionUseCase($loggerMock, $repositoryMock);

        $output = $useCase->run($input);

        $expectedOutput = new FindPermissionUseCaseOutputDto(...(array) $mockFind);
        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_invalid_id(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn(null);

        $input = new FindPermissionUseCaseInputDto(1);

        $useCase = new FindPermissionUseCase($loggerMock, $repositoryMock);

        $this->expectExceptionMessage('Invalid id');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
