<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Role\FindRoleUseCase;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Find\{
    FindRoleUseCaseInputDto,
    FindRoleUseCaseOutputDto
};

class FindRoleUseCaseTest extends TestCase
{
    public function test_should_find(): void
    {

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

        $useCase = new FindRoleUseCase($repositoryMock);

        $output = $useCase->run($input);

        $expectedOutput = new FindRoleUseCaseOutputDto(...(array) $mockFind);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_invalid_id(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn(null);

        $input = new FindRoleUseCaseInputDto(1);

        $useCase = new FindRoleUseCase($repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
