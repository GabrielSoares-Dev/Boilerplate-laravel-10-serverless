<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entities\User;
use Src\Application\Dtos\Entities\User\UserEntityDto;

class UserTest extends TestCase
{
    public function test_should_create(): void
    {
        $input = new UserEntityDto('admin', 'test@gmail.com', '11991742156', 'Test@2312');

        $entity = new User($input);

        $entity->create();

        $this->assertTrue(true);
    }

    public function test_should_create_failed_when_name_is_invalid(): void
    {
        $input = new UserEntityDto('', 'test@gmail.com', '11991742156', 'Test@2312');

        $entity = new User($input);

        $this->expectExceptionMessage('Invalid name');

        $entity->create();
    }

    public function test_should_create_failed_when_email_is_invalid(): void
    {
        $input = new UserEntityDto('admin', 'test@gmail.c', '11991742156', 'Test@2312');

        $entity = new User($input);

        $this->expectExceptionMessage('Invalid email');

        $entity->create();
    }

    public function test_should_create_failed_when_phone_number_is_invalid(): void
    {
        $input = new UserEntityDto('admin', 'test@gmail.com', '1199174215', 'Test@2312');

        $entity = new User($input);

        $this->expectExceptionMessage('Invalid phone number');

        $entity->create();
    }

    public function test_should_create_failed_when_password_is_invalid(): void
    {
        $input = new UserEntityDto('admin', 'test@gmail.com', '11991742156', 'Test@');

        $entity = new User($input);

        $this->expectExceptionMessage('Invalid password');

        $entity->create();
    }
}
