<?php

namespace App\Interfaces\Repositories;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $input);
    public function findByEmail(string $email);
}