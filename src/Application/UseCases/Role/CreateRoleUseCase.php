<?php

namespace Src\Application\UseCases\Role;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Entities\Role;
use Src\Domain\Repositories\RoleRepositoryInterface;

class CreateRoleUseCase implements BaseUseCaseInterface
{
    protected RoleRepositoryInterface $repository;

    protected $defaultGuardName = 'api';

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function valid(array $input)
    {
        $entity = new Role();

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
            throw new BusinessException('Role already exists');
        }

        $this->repository->create($input);
    }
}
