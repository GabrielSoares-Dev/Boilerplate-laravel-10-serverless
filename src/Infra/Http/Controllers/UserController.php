<?php

namespace Src\Infra\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\Dtos\UseCases\User\CreateUserUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Services\LoggerServiceInterface;
use Src\Application\UseCases\User\CreateUserUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\User\UserRequest;

class UserController extends Controller
{
    protected LoggerServiceInterface $loggerService;

    protected CreateUserUseCase $createUserUseCase;

    public function __construct(
        LoggerServiceInterface $loggerService,
        CreateUserUseCase $createUserUseCase
    ) {
        $this->loggerService = $loggerService;
        $this->createUserUseCase = $createUserUseCase;
    }

    public function store(UserRequest $request): JsonResponse
    {
        $input = new CreateUserUseCaseInputDto(...$request->all());

        try {

            $this->loggerService->info('START UserController store');

            $this->loggerService->debug('Input UserController store', $input);

            $this->createUserUseCase->run($input);

            $this->loggerService->info('FINISH UserController store');

            return BaseResponse::success('User created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'User already exists';

            if ($isAlreadyExistsError) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error UserController store', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
