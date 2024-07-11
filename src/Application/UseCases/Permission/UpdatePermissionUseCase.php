<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Dtos\Repositories\Permission\UpdatePermissionRepositoryInputDto;
use Src\Application\Dtos\UseCases\Permission\Update\UpdatePermissionUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;
use Src\Domain\Entities\Permission;

class UpdatePermissionUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly PermissionRepositoryInterface $repository
    ) {}

    protected string $defaultGuardName = 'api';

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
