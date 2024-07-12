<?php

namespace Src\Application\Dtos\Entities\User;

class UserEntityDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phoneNumber,
        public readonly string $password
    ) {}
}
