<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Dtos\UseCases\Role\Delete\DeleteRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class DeleteRoleUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly RoleRepositoryInterface $repository
    ) {}

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
