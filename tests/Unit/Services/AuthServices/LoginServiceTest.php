<?php

namespace Tests\Unit;

use App\Helpers\Cryptography;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Services\AuthServices\LoginService;
use Mockery;
use Tests\TestCase;

class LoginServiceTest extends TestCase
{
    public function test_should_be_authenticated(): void
    {
        // $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        // $cryptographyMock = Mockery::mock(Cryptography::class);

        // $input = [
        //     'email' => 'test@gmail.com',
        //     'password' => 'Boilerplate@2023',
        //     'device_name' => 'Postman',
        // ];
        // $mockFindByEmailOutput = [
        //     'id' => 1,
        //     'name' => 'Gabriel',
        //     'email' => 'test@gmail.com',
        //     'password' => '$2y$12$KWSFtZMM.cvqAU5FTLZ0o./qPJWpMCs5Ad3diMqiZ9QWJeuvvf3Xi',
        //     'phone_number' => '11942421224',
        // ];

        // $repositoryMock
        //     ->shouldReceive('findByEmail')
        //     ->andReturn((object) $mockFindByEmailOutput);

        // $passwordHash = $mockFindByEmailOutput['password'];

        // $cryptographyMock->shouldReceive('compare')
        //     ->with($passwordHash, $input['password'])
        //     ->andReturn(true);

        // $service = new LoginService($repositoryMock, $cryptographyMock);

        // $output = $service->run($input);

        // $expectedOutput = [
        //     'statusCode' => 200,
        //     'message' => 'Authenticated',
        //     'content' => [
        //         'accessToken' => 'test-token',
        //     ],
        // ];

        // $this->assertEquals($expectedOutput, $output);

        // Mockery::close();
    }

    public function test_should_be_invalid_credentials_if_not_found_user(): void
    {
        // $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        // $input = [
        //     'email' => 'test@gmail.com',
        //     'password' => 'Test@20',
        //     'device_name' => 'Postman',
        // ];

        // $repositoryMock
        //     ->shouldReceive('findByEmail')
        //     ->andReturn(null);

        // $service = new LoginService($repositoryMock);

        // $this->expectExceptionMessage('Invalid credentials');

        // $service->run($input);

        // Mockery::close();
    }

    public function test_should_be_invalid_credentials_if_password_is_incorrect(): void
    {
        // $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        // $input = [
        //     'email' => 'test@gmail.com',
        //     'password' => 'Test@20',
        //     'device_name' => 'Postman',
        // ];

        // $mockModel = Mockery::mock(User::class);

        // $hashMock->shouldReceive('check')
        //     ->andReturn(false);

        // $repositoryMock
        //     ->shouldReceive('findByEmail')
        //     ->andReturn($mockModel);

        // $service = new LoginService($repositoryMock);

        // $this->expectExceptionMessage('Invalid credentials');

        // $service->run($input);

        // Mockery::close();
    }
}
