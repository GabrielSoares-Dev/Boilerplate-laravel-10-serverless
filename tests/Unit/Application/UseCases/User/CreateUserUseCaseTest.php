<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\User\CreateUserUseCase;
use Src\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCaseTest extends TestCase
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

        $useCase = new CreateUserUseCase($repositoryMock);

        $useCase->run($input);

        $this->assertTrue(true);
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

        $useCase = new CreateUserUseCase($repositoryMock);

        $this->expectExceptionMessage('User already exists');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
