<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Dtos\Repositories\Role\CreateRoleRepositoryInputDto;
use Src\Application\Dtos\UseCases\Role\Create\CreateRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;
use Src\Domain\Entities\Role;

class CreateRoleUseCase
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly RoleRepositoryInterface $repository
    ) {}

    protected string $defaultGuardName = 'api';

    protected function valid(string $name, string $guardName): void
    {
        $entity = new Role();

        $entity->create($name, $guardName);
    }

    protected function alreadyExists(string $name, string $guardName): bool
    {
        return !empty($this->repository->findByName($name, $guardName));
    }

    public function run(CreateRoleUseCaseInputDto $input): void
    {
        $this->loggerService->info('START CreateRoleUseCase');

        $this->loggerService->debug('Input CreateRoleUseCase', $input);

        $name = $input->name;
        $guardName = $this->defaultGuardName;

        $this->valid($name, $guardName);

        $alreadyExists = $this->alreadyExists($name, $guardName);

        if ($alreadyExists) throw new BusinessException('Role already exists');

        $data = new CreateRoleRepositoryInputDto($name, $guardName);

        $this->repository->create($data);

        $this->loggerService->info('FINISH CreateRoleUseCase');
    }
}
