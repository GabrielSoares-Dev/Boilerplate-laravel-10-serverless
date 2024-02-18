<?php

namespace Src\Domain\Dtos\UseCases\Auth\Login;

class LoginUseCaseInputDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
