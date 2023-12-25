<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Permission\UpdatePermissionUseCase;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class UpdatePermissionUseCaseTest extends TestCase
{
    public function test_should_update_permission(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('update')
            ->andReturn(true);

        $input = [
            'id' => 1,
            'name' => 'test',
        ];
        $useCase = new UpdatePermissionUseCase($repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
        Mockery::close();
    }

    public function test_should_invalid_id(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('update')
            ->andReturn(false);

        $input = [
            'id' => 1,
            'name' => 'test',
        ];
        $useCase = new UpdatePermissionUseCase($repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);

        Mockery::close();
    }
}
