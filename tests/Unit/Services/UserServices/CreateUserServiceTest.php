<?php

namespace Tests\Unit;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Services\UserServices\CreateUserService;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateUserServiceTest extends TestCase
{
    public function test_should_create_new_user(): void
    {

        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $input = [
            'name' => 'Gabriel',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
            'password' => 'Test@20',
        ];

        $repositoryMock
            ->shouldReceive('findByEmail')
            ->andReturn(null);

        $repositoryMock
            ->shouldReceive('create')
            ->andReturn($input);

        $service = new CreateUserService($repositoryMock);

        $output = $service->run($input);

        $expectedOutput = [
            'statusCode' => 201,
            'message' => 'User created successfully',
        ];

        $this->assertEquals($expectedOutput, $output);

        Mockery::close();
    }

    public function test_should_user_already_exists(): void
    {

        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $mockFindByEmail = [
            'id' => 1,
            'name' => 'Gabriel',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
        ];

        $input = [
            'name' => 'Gabriel',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
            'password' => 'Test@20',
        ];

        $repositoryMock
            ->shouldReceive('findByEmail')
            ->andReturn($mockFindByEmail);

        $repositoryMock
            ->shouldReceive('create')
            ->andReturn($input);

        $service = new CreateUserService($repositoryMock);

        $this->expectExceptionMessage('User already exists');

        $service->run($input);

        Mockery::close();
    }
}
