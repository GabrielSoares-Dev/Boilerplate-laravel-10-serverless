<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\User;

class UserTest extends TestCase
{
    public function test_should_create(): void
    {
        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.com',
            'phoneNumber' => '11991742156',
            'password' => 'Test@2312',
        ];

        $entity = new User(...$input);

        $entity->create();

        $this->assertTrue(true);
    }

    public function test_should_create_failed_when_name_is_invalid(): void
    {
        $input = [
            'name' => '',
            'email' => 'test@gmail.com',
            'phoneNumber' => '11991742156',
            'password' => 'Test@2312',
        ];

        $entity = new User(...$input);

        $this->expectExceptionMessage('Invalid name');

        $entity->create();
    }

    public function test_should_create_failed_when_email_is_invalid(): void
    {
        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.c',
            'phoneNumber' => '11991742156',
            'password' => 'Test@2312',
        ];

        $entity = new User(...$input);

        $this->expectExceptionMessage('Invalid email');

        $entity->create();
    }

    public function test_should_create_failed_when_phone_number_is_invalid(): void
    {
        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.com',
            'phoneNumber' => '1199174215',
            'password' => 'Test@2312',
        ];

        $entity = new User(...$input);

        $this->expectExceptionMessage('Invalid phone number');

        $entity->create();
    }

    public function test_should_create_failed_when_password_is_invalid(): void
    {
        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.com',
            'phoneNumber' => '11991742156',
            'password' => 'Test@',
        ];

        $entity = new User(...$input);

        $this->expectExceptionMessage('Invalid password');

        $entity->create();
    }
}
