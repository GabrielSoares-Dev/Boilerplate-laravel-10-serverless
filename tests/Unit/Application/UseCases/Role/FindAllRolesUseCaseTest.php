<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Role\FindAllRolesUseCase;
use Src\Domain\Repositories\RoleRepositoryInterface;

class FindAllRolesUseCaseTest extends TestCase
{
    public function test_should_find_all(): void
    {

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

        $useCase = new FindAllRolesUseCase($repositoryMock);

        $output = $useCase->run();

        $expectedOutput = $mockFindAll;

        $this->assertEquals($expectedOutput, $output);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
