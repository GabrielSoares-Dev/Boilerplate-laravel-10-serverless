<?php

namespace Tests\Unit;

use Src\Application\UseCases\Permission\FindAllPermissionsUseCase;
use Src\Domain\Repositories\PermissionRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class FindAllPermissionsUseCaseTest extends TestCase
{
    public function test_should_find_all_permissions(): void
    {

        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);

        $mockFindAll = [
            [
                'id' => 1,
                'name' => 'create_permission',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
            [
                'id' => 2,
                'name' => 'delete_permission',
                'guard_name' => 'api',
                'created_at' => 'now',
                'updated_at' => 'now',
            ]
        ];

        $repositoryMock
            ->shouldReceive('findAll')
            ->andReturn($mockFindAll);

        $input = [];
        $useCase = new FindAllPermissionsUseCase($repositoryMock);

        $output =  $useCase->run($input);

        $expectedOutput = $mockFindAll;

        $this->assertEquals($expectedOutput, $output);
        Mockery::close();
    }
}
