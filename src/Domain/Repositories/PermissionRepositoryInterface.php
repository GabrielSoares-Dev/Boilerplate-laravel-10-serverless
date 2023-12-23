<?php

namespace Src\Domain\Repositories;

interface PermissionRepositoryInterface
{
    public function create(array $input);

    public function findByName(array $input);

    public function findAll();
}
