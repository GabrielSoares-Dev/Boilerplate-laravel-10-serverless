<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Role\DeleteRoleUseCase;
use Src\Domain\Repositories\RoleRepositoryInterface;

class DeleteRoleUseCaseTest extends TestCase
{
    public function test_should_delete(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('delete')
            ->andReturn(true);

        $input = [
            'id' => 1,
        ];
        $useCase = new DeleteRoleUseCase($repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_invalid_id(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('delete')
            ->andReturn(false);

        $input = [
            'id' => 1,
        ];
        $useCase = new DeleteRoleUseCase($repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
