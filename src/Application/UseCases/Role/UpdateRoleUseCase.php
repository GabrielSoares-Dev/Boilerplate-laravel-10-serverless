<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Dtos\Repositories\Role\UpdateRoleRepositoryInputDto;
use Src\Application\Dtos\UseCases\Role\Update\UpdateRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;
use Src\Domain\Entities\Role;

class UpdateRoleUseCase
{
    protected LoggerServiceInterface $loggerService;

    protected RoleRepositoryInterface $repository;

    protected string $defaultGuardName = 'api';

    public function __construct(
        LoggerServiceInterface $loggerService,
        RoleRepositoryInterface $repository
    ) {
        $this->loggerService = $loggerService;
        $this->repository = $repository;
    }

    protected function valid(string $name): void
    {
        $guardName = $this->defaultGuardName;

        $entity = new Role();

        $entity->update($name, $guardName);
    }

    public function run(UpdateRoleUseCaseInputDto $input): void
    {
        $this->loggerService->info('START UpdateRoleUseCase');

        $this->loggerService->debug('Input UpdateRoleUseCase', $input);

        $id = $input->id;
        $name = $input->name;

        $this->valid($name);

        $data = new UpdateRoleRepositoryInputDto($name);
        $updated = (bool) $this->repository->update($data, $id);

        if (!$updated) throw new BusinessException('Invalid id');

        $this->loggerService->info('FINISH UpdateRoleUseCase');
    }
}
