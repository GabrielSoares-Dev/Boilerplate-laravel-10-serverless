<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class CreatePermissionUseCase implements BaseUseCaseInterface
{
    protected PermissionRepositoryInterface $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $input): array
    {
        $this->repository->create($input);

        $output = [];

        return $output;
    }
}
