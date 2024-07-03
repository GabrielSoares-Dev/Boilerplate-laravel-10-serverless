<?php

namespace Src\Application\Dtos\UseCases\Auth\Login;

class LoginUseCaseOutputDto
{
    public function __construct(public readonly string $token) {}
}
