<?php

namespace Src\Infra\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\Auth\LoginUseCase;
use Src\Application\UseCases\Auth\LogoutUseCase;
use Src\Domain\Dtos\UseCases\Auth\Login\LoginUseCaseInputDto;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    protected LoginUseCase $loginUseCase;

    protected LogoutUseCase $logoutUseCase;

    public function __construct(
        LoginUseCase $loginUseCase,
        LogoutUseCase $logoutUseCase
    ) {
        $this->loginUseCase = $loginUseCase;
        $this->logoutUseCase = $logoutUseCase;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $input = new LoginUseCaseInputDto(...$request->all());
        try {
            $output = $this->loginUseCase->run($input);

            return BaseResponse::successWithContent('Authenticated', HttpCode::OK, $output);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidCredentialsError = $errorMessage === 'Invalid credentials';

            if ($isInvalidCredentialsError) {
                $httpCode = HttpCode::UNAUTHORIZED;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->logoutUseCase->run();

            return BaseResponse::success('Successfully logged out', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
