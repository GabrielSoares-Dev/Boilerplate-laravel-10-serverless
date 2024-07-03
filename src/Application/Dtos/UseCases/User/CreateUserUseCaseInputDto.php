<?php

namespace Src\Application\Dtos\UseCases\User;

class CreateUserUseCaseInputDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phoneNumber,
        public readonly string $password
    ) {}
}
