<?php

namespace App\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function create(array $input);

    public function findByEmail(string $email);
}
