<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Dtos\UseCases\Permission\Find\{FindPermissionUseCaseOutputDto};
use Src\Application\Dtos\UseCases\Permission\Find\FindPermissionUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class FindPermissionUseCase
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

    public function run(FindPermissionUseCaseInputDto $input): FindPermissionUseCaseOutputDto
    {
        $this->loggerService->info('START FindPermissionUseCase');

        $this->loggerService->debug('Input FindPermissionUseCase', $input);

        $id = $input->id;

        $permission = $this->repository->find($id);

        if (!$permission) throw new BusinessException('Invalid id');

        $this->loggerService->info('FINISH FindPermissionUseCase');

        return new FindPermissionUseCaseOutputDto(...(array) $permission);
    }
}
