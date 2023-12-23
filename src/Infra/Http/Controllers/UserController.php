<?php

namespace Src\Infra\Http\Controllers;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\User\CreateUserUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected CreateUserUseCase $createUserUseCase;

    public function __construct(
        CreateUserUseCase $createUserUseCase
    ) {
        $this->createUserUseCase = $createUserUseCase;
    }

    public function store(UserRequest $request)
    {
        $input = $request->all();

        try {
            $this->createUserUseCase->run($input);

            return BaseResponse::success('User created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'User already exists';

            if ($isAlreadyExistsError) {
                $httpCode = HttpCode::BAD_REQUEST;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
