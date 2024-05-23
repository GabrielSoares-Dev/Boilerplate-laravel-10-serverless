<?php

namespace Src\Application\Dtos\Repositories\User;

class CreateUserRepositoryInputDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phoneNumber,
        public readonly string $password
    ) {
    }
}
