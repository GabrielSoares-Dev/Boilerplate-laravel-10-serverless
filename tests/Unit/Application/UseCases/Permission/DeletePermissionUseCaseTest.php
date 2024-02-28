<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\Mocks\LoggerMock;
use Src\Application\UseCases\Permission\DeletePermissionUseCase;
use Src\Domain\Dtos\UseCases\Permission\Delete\DeletePermissionUseCaseInputDto;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class DeletePermissionUseCaseTest extends TestCase
{
    public function test_should_delete(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('delete')
            ->andReturn(true);

        $input = new DeletePermissionUseCaseInputDto(1);

        $useCase = new DeletePermissionUseCase($loggerMock, $repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_invalid_id(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('delete')
            ->andReturn(false);

        $input = new DeletePermissionUseCaseInputDto(1);

        $useCase = new DeletePermissionUseCase($loggerMock, $repositoryMock);

        $this->expectExceptionMessage('Invalid id');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
