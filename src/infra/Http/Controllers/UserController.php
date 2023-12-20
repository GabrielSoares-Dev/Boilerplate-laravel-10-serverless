<?php

namespace Src\Infra\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Exceptions\HttpException;
use App\Helpers\BaseResponse;
use Src\Infra\Http\Requests\UserRequest;
use Src\Application\UseCases\User\CreateUserUseCase;
use Src\Domain\Enums\HttpCode;

/**
 * @codeCoverageIgnore
 */
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
            $output = $this->createUserUseCase->run($input);
            
            return BaseResponse::success('User created successfully',(int) HttpCode::CREATED);
        } catch (BusinessException $exception) {
            throw new HttpException($exception->getMessage(), $exception->getStatusCode() ?? 500);
        }

    }
}
