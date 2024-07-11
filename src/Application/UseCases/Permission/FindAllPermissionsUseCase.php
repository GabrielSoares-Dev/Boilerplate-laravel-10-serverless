<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class FindAllPermissionsUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly PermissionRepositoryInterface $repository
    ) {}

    public function run(): array
    {
        $this->loggerService->info('START FindAllPermissionsUseCase');

        $this->loggerService->info('FINISH FindAllPermissionsUseCase');

        return $this->repository->findAll();
    }
}
