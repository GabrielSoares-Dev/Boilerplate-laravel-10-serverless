<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Interfaces\Repositories\PermissionRepositoryInterface;
use App\Services\PermissionServices\CreatePermissionService;

class CreatePermissionServiceTest extends TestCase
{

    public function test_should_be_create_permission(): void
    {
        $repositoryMock = Mockery::mock(PermissionRepositoryInterface::class);


        $input = [
            'name' => 'ADMIN',
        ];


        $repositoryMock
            ->shouldReceive('create')
            ->andReturn($input);

        $service = new CreatePermissionService($repositoryMock);

        $output = $service->run($input);

        $expectedOutput = [
            'statusCode' => 201,
            'message' => 'Permission created successfully',
        ];

        $this->assertEquals($expectedOutput, $output);

        Mockery::close();
    }
}
