<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class FindAllPermissionsUseCase
{
    protected LoggerServiceInterface $loggerService;

    protected PermissionRepositoryInterface $repository;

    public function __construct(
        LoggerServiceInterface $loggerService,
        PermissionRepositoryInterface $repository
    ) {
        $this->loggerService = $loggerService;
        $this->repository = $repository;
    }

    public function run(): array
    {
        $this->loggerService->info('START FindAllPermissionsUseCase');

        $this->loggerService->info('FINISH FindAllPermissionsUseCase');

        return $this->repository->findAll();
    }
}
