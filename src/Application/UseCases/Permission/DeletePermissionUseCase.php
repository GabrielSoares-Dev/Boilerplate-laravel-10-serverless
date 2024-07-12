<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Dtos\UseCases\Permission\Delete\DeletePermissionUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class DeletePermissionUseCase
{
    public function __construct(
        private readonly LoggerServiceInterface $loggerService,
        private readonly PermissionRepositoryInterface $repository
    ) {}

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
