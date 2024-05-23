<?php

namespace Src\Infra\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\Dtos\UseCases\Auth\Login\LoginUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Services\LoggerServiceInterface;
use Src\Application\UseCases\Auth\LoginUseCase;
use Src\Application\UseCases\Auth\LogoutUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    protected LoggerServiceInterface $loggerService;

    protected LoginUseCase $loginUseCase;

    protected LogoutUseCase $logoutUseCase;

    public function __construct(
        LoggerServiceInterface $loggerService,
        LoginUseCase $loginUseCase,
        LogoutUseCase $logoutUseCase
    ) {
        $this->loggerService = $loggerService;
        $this->loginUseCase = $loginUseCase;
        $this->logoutUseCase = $logoutUseCase;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $input = new LoginUseCaseInputDto(...$request->all());

        try {

            $this->loggerService->info('START AuthController login');

            $this->loggerService->debug('Input AuthController login', $input);

            $output = $this->loginUseCase->run($input);

            $this->loggerService->debug('Output AuthController login', $output);

            $this->loggerService->info('FINISH AuthController login');

            return BaseResponse::successWithContent('Authenticated', HttpCode::OK, $output);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidCredentialsError = $errorMessage === 'Invalid credentials';

            if ($isInvalidCredentialsError) $httpCode = HttpCode::UNAUTHORIZED;

            $this->loggerService->error('Error AuthController login', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function logout(): JsonResponse
    {
        try {

            $this->loggerService->info('START AuthController logout');

            $this->logoutUseCase->run();

            $this->loggerService->info('FINISH AuthController logout');

            return BaseResponse::success('Successfully logged out', HttpCode::OK);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $this->loggerService->error('Error AuthController logout', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
