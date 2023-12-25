<?php

namespace Src\Infra\Http\Controllers;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\Role\CreateRoleUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    protected CreateRoleUseCase $createRoleUseCase;

    public function __construct(
        CreateRoleUseCase $createRoleUseCase,
    ) {
        $this->createRoleUseCase = $createRoleUseCase;
    }

    public function index()
    {
    }

    public function store(RoleRequest $request)
    {
        $input = $request->all();

        try {
            $this->createRoleUseCase->run($input);

            return BaseResponse::success('Role created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'Role already exists';

            if ($isAlreadyExistsError) {
                $httpCode = HttpCode::BAD_REQUEST;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function show(string $id)
    {
    }

    public function update(RoleRequest $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
