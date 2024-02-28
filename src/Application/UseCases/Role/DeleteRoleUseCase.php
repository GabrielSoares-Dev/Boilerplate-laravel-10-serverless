<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Services\LoggerServiceInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Delete\DeleteRoleUseCaseInputDto;

class DeleteRoleUseCase
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

    public function run(DeleteRoleUseCaseInputDto $input): void
    {
        $this->loggerService->info('START DeleteRoleUseCase');

        $this->loggerService->debug('Input DeleteRoleUseCase', $input);

        $id = $input->id;

        $deleted = $this->repository->delete($id);

        if (!$deleted)  throw new BusinessException('Invalid id');

        $this->loggerService->info('FINISH DeleteRoleUseCase');
    }
}
