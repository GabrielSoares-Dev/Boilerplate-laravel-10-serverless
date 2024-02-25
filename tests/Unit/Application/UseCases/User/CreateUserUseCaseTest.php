<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\User\CreateUserUseCase;
use Src\Domain\Repositories\UserRepositoryInterface;
use Src\Domain\Dtos\UseCases\User\CreateUserUseCaseInputDto;

class CreateUserUseCaseTest extends TestCase
{
    public function test_should_create(): void
    {

        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $input = new CreateUserUseCaseInputDto('Gabriel', 'test@gmail.com', '11942421224', 'Test@20');

        $mockCreateUserOutput = (object) [
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
            ->andReturn($mockCreateUserOutput);

        $repositoryMock
            ->shouldReceive('assignRole')
            ->andReturn(true);

        $useCase = new CreateUserUseCase($repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_already_exists(): void
    {

        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $mockFindByEmail = (object) [
            'id' => 1,
            'name' => 'Gabriel',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
        ];

        $input = new CreateUserUseCaseInputDto('Gabriel', 'test@gmail.com', '11942421224', 'Test@20');

        $repositoryMock
            ->shouldReceive('findByEmail')
            ->andReturn($mockFindByEmail);

        $repositoryMock
            ->shouldReceive('create')
            ->andReturn(null);

        $repositoryMock
            ->shouldReceive('assignRole')
            ->andReturn(false);

        $useCase = new CreateUserUseCase($repositoryMock);

        $this->expectExceptionMessage('User already exists');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
