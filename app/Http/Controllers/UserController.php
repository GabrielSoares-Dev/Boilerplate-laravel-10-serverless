<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Exceptions\HttpException;
use App\Helpers\BaseResponse;
use App\Http\Requests\UserRequest;
use App\Services\UserServices\CreateUserService;

/**
 * @codeCoverageIgnore
 */
class UserController extends Controller
{
    protected CreateUserService $createUserService;

    public function __construct(
        CreateUserService $createUserService
    ) {
        $this->createUserService = $createUserService;
    }

    public function store(UserRequest $request)
    {

        $input = $request->all();

        try {
            $output = $this->createUserService->run($input);

            return BaseResponse::success($output['message'], $output['statusCode']);
        } catch (BusinessException $exception) {
            throw new HttpException($exception->getMessage(), $exception->getStatusCode() ?? 500);
        }

    }
}
