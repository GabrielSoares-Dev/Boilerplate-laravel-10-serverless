<?php

namespace Src\Application\Dtos\UseCases\Auth\Login;

class LoginUseCaseInputDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}
}
