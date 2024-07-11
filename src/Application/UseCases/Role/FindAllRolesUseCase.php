<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class FindAllRolesUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly RoleRepositoryInterface $repository
    ) {}

    public function run(): array
    {
        $this->loggerService->info('START FindAllRolesUseCase');

        $this->loggerService->info('FINISH FindAllRolesUseCase');

        return $this->repository->findAll();
    }
}
