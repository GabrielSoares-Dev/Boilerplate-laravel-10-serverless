<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Role\CreateRoleUseCase;
use Src\Domain\Repositories\RoleRepositoryInterface;

class CreateRoleUseCaseTest extends TestCase
{
    public function test_should_create(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $input = [
            'name' => 'admin',
        ];

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn(null);

        $repositoryMock
            ->shouldReceive('create')
            ->andReturn($input);

        $useCase = new CreateRoleUseCase($repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_already_exists(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $mockFindByName = [
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $input = [
            'name' => 'admin',
        ];

        $repositoryMock
            ->shouldReceive('findByName')
            ->andReturn($mockFindByName);

        $useCase = new CreateRoleUseCase($repositoryMock);

        $this->expectExceptionMessage('Role already exists');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
