<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\Mocks\LoggerMock;
use Src\Application\UseCases\Role\UpdateRoleUseCase;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Update\UpdateRoleUseCaseInputDto;

class UpdateRoleUseCaseTest extends TestCase
{
    public function test_should_update(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('update')
            ->andReturn(true);

        $input = new UpdateRoleUseCaseInputDto(1, 'test');

        $useCase = new UpdateRoleUseCase($loggerMock, $repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_invalid_id(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('update')
            ->andReturn(false);

        $input = new UpdateRoleUseCaseInputDto(1, 'test');

        $useCase = new UpdateRoleUseCase($loggerMock, $repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
