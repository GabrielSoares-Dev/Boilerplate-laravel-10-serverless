<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Src\Infra\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    private $path = '/v1/auth/logout';

    public function test_logged_out(): void
    {

        $user = User::factory()->create();

        Auth::login($user);

        $output = $this->post($this->path);

        $expectedOutput = [
            'statusCode' => 200,
            'message' => 'Successfully logged out',

        ];

        $output->assertStatus(200);
        $output->assertJson($expectedOutput);
    }
}
