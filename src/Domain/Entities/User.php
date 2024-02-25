<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;

class User
{
    protected ?string $name;

    protected ?string $email;

    protected ?int $phoneNumber;

    protected ?string $password;

    public function __construct(?string $name, ?string $email, ?int $phoneNumber, ?string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
    }

    public function create(): void
    {
        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/';

        $invalidName = empty($this->name);
        $invalidEmail = !(bool) preg_match($emailRegex, $this->email);
        $invalidPhoneNumber = strlen((string) $this->phoneNumber) !== 11;
        $invalidPassword = !(bool) preg_match($passwordRegex, $this->password);

        if ($invalidName) throw new BusinessException('Invalid name');

        if ($invalidEmail)  throw new BusinessException('Invalid email');

        if ($invalidPhoneNumber) throw new BusinessException('Invalid phone number');

        if ($invalidPassword) throw new BusinessException('Invalid password');
    }
}
