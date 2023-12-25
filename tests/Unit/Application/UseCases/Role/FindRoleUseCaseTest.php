<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Role\FindRoleUseCase;
use Src\Domain\Repositories\RoleRepositoryInterface;

class FindRoleUseCaseTest extends TestCase
{
    public function test_should_find(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $mockFind = [
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'api',
            'created_at' => 'now',
            'updated_at' => 'now',
        ];

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn($mockFind);

        $input = [
            'id' => 1,
        ];
        $useCase = new FindRoleUseCase($repositoryMock);

        $output = $useCase->run($input);

        $expectedOutput = $mockFind;
        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }

    public function test_should_invalid_id(): void
    {

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn(null);

        $input = [
            'id' => 1,
        ];
        $useCase = new FindRoleUseCase($repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);

        Mockery::close();
    }
}
