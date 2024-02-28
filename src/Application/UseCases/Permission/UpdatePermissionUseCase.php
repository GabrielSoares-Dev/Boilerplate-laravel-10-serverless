<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Dtos\Repositories\Permission\UpdatePermissionRepositoryInputDto;
use Src\Domain\Dtos\UseCases\Permission\Update\UpdatePermissionUseCaseInputDto;
use Src\Domain\Entities\Permission;
use Src\Domain\Services\LoggerServiceInterface;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class UpdatePermissionUseCase
{
    protected LoggerServiceInterface $loggerService;

    protected PermissionRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(
        LoggerServiceInterface $loggerService,
        PermissionRepositoryInterface $repository
    ) {
        $this->loggerService = $loggerService;
        $this->repository = $repository;
    }

    protected function valid(string $name, string $guardName): void
    {
        $entity = new Permission();

        $entity->create($name, $guardName);
    }

    public function run(UpdatePermissionUseCaseInputDto $input): void
    {
        $this->loggerService->info('START UpdatePermissionUseCase');

        $this->loggerService->debug('Input UpdatePermissionUseCase', $input);

        $id = $input->id;
        $name = $input->name;
        $guardName = $this->defaultGuardName;

        $this->valid($name, $guardName);

        $data = new UpdatePermissionRepositoryInputDto($name);

        $updated = $this->repository->update($data, $id);

        if (!$updated)  throw new BusinessException('Invalid id');

        $this->loggerService->info('FINISH UpdatePermissionUseCase');
    }
}
