<?php

namespace Src\Domain\Repositories;

interface UserRepositoryInterface
{
    public function create(array $input);

    public function findByEmail(string $email);

    public function assignRole(array $input);
}
