<?php

namespace Src\Application\UseCases\User;

use App\Exceptions\BusinessException;
use Src\Application\UseCases\BaseUseCaseInterface;
use Src\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCase implements BaseUseCaseInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function foundUserBySameEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function run(array $input): array
    {

        $email = $input['email'];

        if ($this->foundUserBySameEmail($email)) {
            throw new BusinessException('User already exists', 400);
        }

        $this->repository->create($input);

        $output = [];

        return $output;
    }
}
