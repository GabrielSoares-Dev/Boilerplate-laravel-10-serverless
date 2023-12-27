<?php

namespace Src\Application\UseCases\Permission;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Entities\Permission;
use Src\Domain\Repositories\PermissionRepositoryInterface;

class CreatePermissionUseCase implements BaseUseCaseInterface
{
    protected PermissionRepositoryInterface $repository;

    protected $defaultGuardName = 'api';

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(array $input)
    {
        $entity = new Permission();

        $entity->create($input);
    }

    protected function alreadyExists(array $input)
    {
        return ! empty($this->repository->findByName($input));
    }

    public function run(array $input)
    {

        $input['guard_name'] = $this->defaultGuardName;

        $this->valid($input);

        $alreadyExists = $this->alreadyExists($input);

        if ($alreadyExists) {
            throw new BusinessException('Permission already exists');
        }

        $this->repository->create($input);
    }
}
