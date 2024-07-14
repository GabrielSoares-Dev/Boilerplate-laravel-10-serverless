<?php

namespace Tests;

use Src\Infra\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class AuthenticatedTestCase extends TestCase
{
    use RefreshDatabase;

    protected $tokenFormatted;

    protected $headers;

    protected $role;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create()->assignRole($this->role);

        $token = auth()->login($user);
        $this->tokenFormatted = "Bearer $token";
        $this->headers = ['Authorization' => $this->tokenFormatted];
    }
}
