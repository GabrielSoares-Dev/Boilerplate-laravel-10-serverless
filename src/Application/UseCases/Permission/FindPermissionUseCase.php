<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Dtos\UseCases\Permission\Find\{FindPermissionUseCaseOutputDto};
use Src\Application\Dtos\UseCases\Permission\Find\FindPermissionUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class FindPermissionUseCase
{
    public function __construct(
        private readonly LoggerServiceInterface $loggerService,
        private readonly PermissionRepositoryInterface $repository
    ) {}

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
