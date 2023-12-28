<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Domain\Enums\Role;
use Src\Infra\Models\User;
use Src\Infra\Repositories\UserRepository\UserEloquentRepository;

class UserRepositoryTest extends TestCase
{
    public function test_should_create(): void
    {
        $mockModel = Mockery::mock(User::class);

        $input = [
            'name' => 'Gabriel',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
            'password' => 'Test@20',
        ];

        $mockModel
            ->shouldReceive('create')
            ->andReturn($input);

        $userRepository = new UserEloquentRepository($mockModel);

        $output = $userRepository->create($input);

        $expectedOutput = $input;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_find_by_email(): void
    {
        $mockModel = Mockery::mock(User::class);

        $output = [
            'id' => 1,
            'name' => 'Gabriel',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
        ];

        $email = 'test@gmail.com';

        $mockModel
            ->shouldReceive('where')
            ->with('email', $email)
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('first')
            ->andReturn($output);

        $userRepository = new UserEloquentRepository($mockModel);

        $output = $userRepository->findByEmail($email);

        $expectedOutput = $output;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_assign_role(): void
    {
        $mockModel = Mockery::mock(User::class);

        $email = 'test@gmail.com';

        $mockModel
            ->shouldReceive('where')
            ->with('email', $email)
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('first')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('first')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('assignRole')
            ->andReturn(true);

        $userRepository = new UserEloquentRepository($mockModel);

        $input = [
            'email' => 'test@gmail.com',
            'role' => Role::ADMIN,
        ];
        $output = $userRepository->assignRole($input);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
