<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\User;

class UserTest extends TestCase
{
    public function test_should_create(): void
    {

        $entity = new User();

        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.com',
            'phone_number' => 11991742156,
            'password' => 'Test@2312',
        ];

        $expectedOutput = [
            'name' => 'admin',
            'email' => 'test@gmail.com',
            'phone_number' => 11991742156,
        ];

        $output = $entity->create($input);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_create_failed_when_name_is_invalid(): void
    {

        $entity = new User();

        $input = [
            'name' => '',
            'email' => 'test@gmail.com',
            'phone_number' => 11991742156,
            'password' => 'Test@2312',
        ];

        $this->expectExceptionMessage('Invalid name');

        $entity->create($input);
    }

    public function test_should_create_failed_when_email_is_invalid(): void
    {

        $entity = new User();

        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.c',
            'phone_number' => 11991742156,
            'password' => 'Test@2312',
        ];

        $this->expectExceptionMessage('Invalid email');

        $entity->create($input);
    }

    public function test_should_create_failed_when_phone_number_is_invalid(): void
    {

        $entity = new User();

        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.com',
            'phone_number' => 1199174215,
            'password' => 'Test@2312',
        ];

        $this->expectExceptionMessage('Invalid phone number');

        $entity->create($input);
    }

    public function test_should_create_failed_when_password_is_invalid(): void
    {

        $entity = new User();

        $input = [
            'name' => 'admin',
            'email' => 'test@gmail.com',
            'phone_number' => 11991742156,
            'password' => 'Test@',
        ];

        $this->expectExceptionMessage('Invalid password');

        $entity->create($input);
    }
}
