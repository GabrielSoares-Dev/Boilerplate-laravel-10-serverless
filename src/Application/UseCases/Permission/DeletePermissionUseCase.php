<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\UseCases\Permission\Delete\DeletePermissionUseCaseInputDto;
use Src\Domain\Services\LoggerServiceInterface;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class DeletePermissionUseCase
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

    public function run(DeletePermissionUseCaseInputDto $input): void
    {
        $this->loggerService->info('START DeletePermissionUseCase');

        $this->loggerService->debug('Input DeletePermissionUseCase', $input);

        $id = $input->id;

        $deleted = $this->repository->delete($id);

        if (!$deleted) throw new BusinessException('Invalid id');

        $this->loggerService->info('FINISH DeletePermissionUseCase');
    }
}
