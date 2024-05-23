<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Dtos\Repositories\Permission\CreatePermissionRepositoryInputDto;
use Src\Application\Dtos\UseCases\Permission\Create\CreatePermissionUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\PermissionRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;
use Src\Domain\Entities\Permission;

class CreatePermissionUseCase
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

    protected function alreadyExists(string $name, string $guardName): bool
    {
        return !empty($this->repository->findByName($name, $guardName));
    }

    public function run(CreatePermissionUseCaseInputDto $input): void
    {
        $this->loggerService->info('START CreatePermissionUseCase');

        $this->loggerService->debug('Input CreatePermissionUseCase', $input);

        $name = $input->name;
        $guardName = $this->defaultGuardName;

        $this->valid($name, $guardName);

        $alreadyExists = $this->alreadyExists($name, $guardName);

        if ($alreadyExists) throw new BusinessException('Permission already exists');

        $data = new CreatePermissionRepositoryInputDto($name, $guardName);

        $this->repository->create($data);

        $this->loggerService->info('FINISH CreatePermissionUseCase');
    }
}
