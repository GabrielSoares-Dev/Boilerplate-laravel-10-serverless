<?php

namespace Src\Domain\Entities;

use Src\Application\Exceptions\BusinessException;

class User
{
    protected ?string $name;

    protected ?string $email;

    protected ?int $phoneNumber;

    protected ?string $password;

    public function create(array $input)
    {
        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/';

        $invalidName = empty($input['name']);
        $invalidEmail = ! (bool) preg_match($emailRegex, $input['email']);
        $invalidPhoneNumber = strlen((string) $input['phone_number']) !== 11;
        $invalidPassword = ! (bool) preg_match($passwordRegex, $input['password']);

        if ($invalidName) {
            throw new BusinessException('Invalid name');
        }

        if ($invalidEmail) {
            throw new BusinessException('Invalid email');
        }

        if ($invalidPhoneNumber) {
            throw new BusinessException('Invalid phone number');
        }

        if ($invalidPassword) {
            throw new BusinessException('Invalid password');
        }

        $this->name = $input['name'];
        $this->email = $input['email'];
        $this->phoneNumber = $input['phone_number'];

        return $this->toArray();
    }

    protected function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
        ];
    }
}
