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
            [
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
            [
                'id' => 2,
                'name' => 'operator',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
        ];

        $repositoryMock
            ->shouldReceive('findAll')
            ->andReturn($mockFindAll);

        $input = [];
        $useCase = new FindAllRolesUseCase($repositoryMock);

        $output = $useCase->run($input);

        $expectedOutput = $mockFindAll;

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }
}
