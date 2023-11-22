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
            ->shouldReceive('create')
            ->andReturn($input);

        $service = new CreateUserService($repositoryMock);

        $output = $service->run($input);

        $expectedOutput = [
            'statusCode' => 201,
            'Message' => 'User created successfully',
        ];

        $this->assertEquals($expectedOutput, $output);
    }
}
