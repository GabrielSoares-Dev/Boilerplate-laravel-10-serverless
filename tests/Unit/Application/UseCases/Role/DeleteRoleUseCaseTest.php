<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Dtos\UseCases\Role\Delete\DeleteRoleUseCaseInputDto;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\UseCases\Role\DeleteRoleUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class DeleteRoleUseCaseTest extends TestCase
{
    public function test_should_delete(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('delete')
            ->andReturn(true);

        $input = new DeleteRoleUseCaseInputDto(1);

        $useCase = new DeleteRoleUseCase($loggerMock, $repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_invalid_id(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('delete')
            ->andReturn(false);

        $input = new DeleteRoleUseCaseInputDto(1);

        $useCase = new DeleteRoleUseCase($loggerMock, $repositoryMock);

        $this->expectExceptionMessage('Invalid id');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
