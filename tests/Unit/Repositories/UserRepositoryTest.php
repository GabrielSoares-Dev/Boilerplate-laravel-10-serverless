<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository\UserEloquentRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public function test_should_create_new_user(): void
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

        Mockery::close();
    }
}
