<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Mockery;
use Src\Infra\Services\AuthService\JwtAuthService;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    public function test_should_generate_token(): void
    {

        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@12',
        ];

        $mockToken = 'test-token';

        Auth::shouldReceive('login')
            ->with($input)
            ->andReturn($mockToken);

        $service = new JwtAuthService();

        $output = $service->generateToken($input);

        $expectedOutput = $mockToken;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_validate_credentials(): void
    {

        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@12',
        ];

        Auth::shouldReceive('validate')
            ->with($input)
            ->andReturn(true);

        $service = new JwtAuthService();

        $output = $service->validateCredentials($input);

        $expectedOutput = true;

        $this->assertEquals($expectedOutput, $output);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
