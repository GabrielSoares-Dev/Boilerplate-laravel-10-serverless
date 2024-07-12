<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;
use Src\Application\Dtos\Entities\User\UserEntityDto;

class User
{
    public function __construct(private readonly UserEntityDto $input) {}

    protected function validateName(): bool
    {
        return !empty($this->input->name);
    }

    protected function validateEmail(): bool
    {
        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        return (bool) preg_match($emailRegex, $this->input->email);
    }

    protected function validatePhoneNumber(): bool
    {
        return strlen($this->input->phoneNumber) === 11;
    }

    protected function validatePassword(): bool
    {
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/';

        return (bool) preg_match($passwordRegex, $this->input->password);
    }

    public function create(): void
    {
        if (!$this->validateName()) throw new BusinessException('Invalid name');

        if (!$this->validateEmail())  throw new BusinessException('Invalid email');

        if (!$this->validatePhoneNumber()) throw new BusinessException('Invalid phone number');

        if (!$this->validatePassword()) throw new BusinessException('Invalid password');
    }
}
