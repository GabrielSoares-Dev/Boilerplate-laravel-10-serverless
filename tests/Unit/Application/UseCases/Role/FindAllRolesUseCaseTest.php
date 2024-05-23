<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\UseCases\Role\FindAllRolesUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class FindAllRolesUseCaseTest extends TestCase
{
    public function test_should_find_all(): void
    {
        $loggerMock = LoggerMock::mock();

        $repositoryMock = Mockery::mock(RoleRepositoryInterface::class);

        $mockFindAll = [
            (object) [
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
        ];

        $repositoryMock
            ->shouldReceive('findAll')
            ->andReturn($mockFindAll);

        $useCase = new FindAllRolesUseCase($loggerMock, $repositoryMock);

        $output = $useCase->run();

        $expectedOutput = $mockFindAll;

        $this->assertEquals($expectedOutput, $output);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
