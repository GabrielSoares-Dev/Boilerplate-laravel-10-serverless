<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Dtos\UseCases\Role\Find\{FindRoleUseCaseOutputDto};
use Src\Application\Dtos\UseCases\Role\Find\FindRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;

class FindRoleUseCase
{
    public function __construct(
        private readonly LoggerServiceInterface $loggerService,
        private readonly RoleRepositoryInterface $repository
    ) {}

    public function run(FindRoleUseCaseInputDto $input): FindRoleUseCaseOutputDto
    {
        $this->loggerService->info('START FindRoleUseCase');

        $this->loggerService->debug('Input FindRoleUseCase', $input);

        $id = $input->id;

        $role = $this->repository->find($id);

        if (!$role)  throw new BusinessException('Invalid id');

        $this->loggerService->info('FINISH FindRoleUseCase');

        return new FindRoleUseCaseOutputDto(...(array) $role);
    }
}
