<?php

namespace Src\Application\UseCases\Role;

use Src\Domain\Services\LoggerServiceInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;

class FindAllRolesUseCase
{
    protected LoggerServiceInterface $loggerService;

    protected RoleRepositoryInterface $repository;

    public function __construct(
        LoggerServiceInterface $loggerService,
        RoleRepositoryInterface $repository
    ) {
        $this->loggerService = $loggerService;
        $this->repository = $repository;
    }

    public function run(): array
    {
        $this->loggerService->info('START FindAllRolesUseCase');

        $this->loggerService->info('FINISH FindAllRolesUseCase');

        return $this->repository->findAll();
    }
}
