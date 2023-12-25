<?php

namespace Src\Domain\Repositories;

interface RoleRepositoryInterface
{
    public function create(array $input);

    public function findByName(array $input);

    public function find(string $id);

    // public function update(array $input, string $id);

    public function findAll();

    // public function delete(string $id);
}
