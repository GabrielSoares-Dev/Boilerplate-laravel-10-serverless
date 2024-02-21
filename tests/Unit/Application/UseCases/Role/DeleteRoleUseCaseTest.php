<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Role\DeleteRoleUseCase;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Delete\DeleteRoleUseCaseInputDto;

class DeleteRoleUseCaseTest extends TestCase
{
    public function test_should_delete(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('delete')
            ->andReturn(true);

        $input = new DeleteRoleUseCaseInputDto(1);

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

        $input = new DeleteRoleUseCaseInputDto(1);
        
        $useCase = new DeleteRoleUseCase($repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
