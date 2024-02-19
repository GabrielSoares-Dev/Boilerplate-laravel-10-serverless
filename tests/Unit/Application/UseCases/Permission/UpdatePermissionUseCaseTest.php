<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Permission\UpdatePermissionUseCase;
use Src\Domain\Dtos\UseCases\Permission\Update\UpdatePermissionUseCaseInputDto;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class UpdatePermissionUseCaseTest extends TestCase
{
    public function test_should_update(): void
    {
        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('update')
            ->andReturn(true);

        $input = new UpdatePermissionUseCaseInputDto(1, 'test');

        $useCase = new UpdatePermissionUseCase($repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_invalid_id(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('update')
            ->andReturn(false);

        $input = new UpdatePermissionUseCaseInputDto(1, 'test');

        $useCase = new UpdatePermissionUseCase($repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
