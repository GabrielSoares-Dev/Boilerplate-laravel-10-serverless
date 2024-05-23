<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Dtos\UseCases\Role\Find\{FindRoleUseCaseOutputDto};
use Src\Application\Dtos\UseCases\Role\Find\FindRoleUseCaseInputDto;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\UseCases\Role\FindRoleUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class FindRoleUseCaseTest extends TestCase
{
    public function test_should_find(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $mockFind = (object) [
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn($mockFind);

        $input = new FindRoleUseCaseInputDto(1);

        $useCase = new FindRoleUseCase($loggerMock, $repositoryMock);

        $output = $useCase->run($input);

        $expectedOutput = new FindRoleUseCaseOutputDto(...(array) $mockFind);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_invalid_id(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn(null);

        $input = new FindRoleUseCaseInputDto(1);

        $useCase = new FindRoleUseCase($loggerMock, $repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
