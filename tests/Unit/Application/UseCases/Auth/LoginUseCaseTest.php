<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Auth\LoginUseCase;
use Src\Domain\Dtos\UseCases\Auth\Login\LoginUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Auth\Login\LoginUseCaseOutputDto;
use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Domain\Services\AuthServiceInterface;

class LoginUseCaseTest extends TestCase
{
    public function test_should_logged(): void
    {
        $authServiceMock = Mockery::mock(AuthServiceInterface::class);
        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $findByEmailMock = [
            'id' => 1,
            'name' => 'test',
            'email' => 'test@gmail.com',
        ];

        $input = new LoginUseCaseInputDto('test@gmail.com', 'Test@20');

        $authServiceMock
            ->shouldReceive('validateCredentials')
            ->andReturn(true);

        $userRepositoryMock
            ->shouldReceive('findByEmail')
            ->andReturn($findByEmailMock);

        $mockToken = 'test-token';

        $authServiceMock
            ->shouldReceive('generateToken')
            ->andReturn($mockToken);

        $useCase = new LoginUseCase($authServiceMock, $userRepositoryMock);

        $output = $useCase->run($input);

        $expectedOutput = new LoginUseCaseOutputDto($mockToken);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_invalid_credentials(): void
    {

        $authServiceMock = Mockery::mock(AuthServiceInterface::class);
        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $input = new LoginUseCaseInputDto('test@gmail.com', 'Test@20');

        $authServiceMock
            ->shouldReceive('validateCredentials')
            ->andReturn(false);

        $userRepositoryMock
            ->shouldReceive('findByEmail')
            ->andReturn(null);

        $mockToken = null;

        $authServiceMock
            ->shouldReceive('generateToken')
            ->andReturn($mockToken);

        $useCase = new LoginUseCase($authServiceMock, $userRepositoryMock);

        $this->expectExceptionMessage('Invalid credentials');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
