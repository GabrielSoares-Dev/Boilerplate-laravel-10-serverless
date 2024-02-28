<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Domain\Services\LoggerServiceInterface;
use Src\Domain\Repositories\RoleRepositoryInterface;
use Src\Domain\Dtos\UseCases\Role\Find\{
    FindRoleUseCaseInputDto,
    FindRoleUseCaseOutputDto
};

class FindRoleUseCase
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
