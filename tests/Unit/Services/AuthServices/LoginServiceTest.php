<?php

namespace Tests\Unit;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Services\AuthServices\LoginService;
use Mockery;
use Tests\TestCase;

class LoginServiceTest extends TestCase
{
    public function test_should_be_authenticated(): void
    {
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@20',
            'device_name' => 'Postman',
        ];
        $mockModel = Mockery::mock(User::class);

        $mockModel->shouldReceive('createToken')
            ->with($input['device_name'])
            ->andReturn((object) ['plainTextToken' => 'test-token']);

        $repositoryMock
            ->shouldReceive('findByEmail')
            ->andReturn($mockModel);

        $service = new LoginService($repositoryMock);

        $output = $service->run($input);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Authenticated',
            'content' => [
                'accessToken' => 'test-token',
            ],
        ];

        $this->assertEquals($expectedOutput, $output);

        Mockery::close();
    }

    public function test_should_be_invalid_credentials_if_not_found_user(): void
    {
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@20',
            'device_name' => 'Postman',
        ];

        $repositoryMock
            ->shouldReceive('findByEmail')
            ->andReturn(null);

        $service = new LoginService($repositoryMock);

        $this->expectExceptionMessage('Invalid credentials');

        $service->run($input);

        Mockery::close();
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
