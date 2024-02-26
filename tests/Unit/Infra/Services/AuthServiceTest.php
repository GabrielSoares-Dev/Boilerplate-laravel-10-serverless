<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Mockery;
use Src\Infra\Services\AuthService\JwtAuthService;
use Tests\TestCase;
use Src\Infra\Models\User;

class AuthServiceTest extends TestCase
{
    public function test_should_generate_token(): void
    {
        $mockModel = Mockery::mock(User::class);

        $mockModel
            ->shouldReceive('where')
            ->andReturnSelf();

        $mockModel
            ->shouldReceive('first')
            ->andReturnSelf();

        $mockToken = 'test-token';

        Auth::shouldReceive('login')
            ->andReturn($mockToken);

        $service = new JwtAuthService($mockModel);

        $output = $service->generateToken('test@gmail.com');

        $expectedOutput = $mockToken;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_validate_credentials(): void
    {
        $mockModel = Mockery::mock(User::class);
        Auth::shouldReceive('validate')
            ->andReturn(true);

        $service = new JwtAuthService($mockModel);

        $output = $service->validateCredentials('test@gmail.com', 'Test@12');

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_validate_token(): void
    {
        $mockModel = Mockery::mock(User::class);

        Auth::shouldReceive('authenticate')
            ->andReturn(true);

        $service = new JwtAuthService($mockModel);

        $output = $service->validateToken();

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_logout(): void
    {
        $mockModel = Mockery::mock(User::class);

        Auth::shouldReceive('logout')
            ->andReturn(true);

        $service = new JwtAuthService($mockModel);

        $service->logout();

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
