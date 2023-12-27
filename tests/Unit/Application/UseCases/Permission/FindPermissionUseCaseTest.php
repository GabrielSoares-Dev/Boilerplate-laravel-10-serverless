<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Permission\FindPermissionUseCase;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class FindPermissionUseCaseTest extends TestCase
{
    public function test_should_find(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFind = [
            'id' => 1,
            'name' => 'create_permission',
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
        $useCase = new FindPermissionUseCase($repositoryMock);

        $output = $useCase->run($input);

        $expectedOutput = $mockFind;
        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_invalid_id(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $repositoryMock
            ->shouldReceive('find')
            ->andReturn(null);

        $input = [
            'id' => 1,
        ];
        $useCase = new FindPermissionUseCase($repositoryMock);

        $this->expectExceptionMessage('Invalid id');
        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
