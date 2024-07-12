<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Dtos\Repositories\Role\UpdateRoleRepositoryInputDto;
use Src\Application\Dtos\UseCases\Role\Update\UpdateRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Repositories\RoleRepositoryInterface;
use Src\Application\Services\LoggerServiceInterface;
use Src\Domain\Entities\Role;
use Src\Application\Dtos\Entities\Role\RoleEntityDto;

class UpdateRoleUseCase
{
    public function __construct(
        private readonly LoggerServiceInterface $loggerService,
        private readonly RoleRepositoryInterface $repository
    ) {}

    private function validate(string $name): void
    {
        $entity = new Role(new RoleEntityDto($name));

        $entity->update();
    }

    public function run(UpdateRoleUseCaseInputDto $input): void
    {
        $this->loggerService->info('START UpdateRoleUseCase');

        $this->loggerService->debug('Input UpdateRoleUseCase', $input);

        $id = $input->id;
        $name = $input->name;

        $this->validate($name);

        $data = new UpdateRoleRepositoryInputDto($name);
        $updated = (bool) $this->repository->update($data, $id);

        if (!$updated) throw new BusinessException('Invalid id');

        $this->loggerService->info('FINISH UpdateRoleUseCase');
    }
}
