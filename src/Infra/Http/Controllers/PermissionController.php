<?php

namespace Src\Infra\Http\Controllers;

use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Application\UseCases\Permission\DeletePermissionUseCase;
use Src\Application\UseCases\Permission\FindAllPermissionsUseCase;
use Src\Application\UseCases\Permission\FindPermissionUseCase;
use Src\Application\UseCases\Permission\UpdatePermissionUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    protected FindAllPermissionsUseCase $findAllPermissionsUseCase;

    protected CreatePermissionUseCase $createPermissionUseCase;

    protected DeletePermissionUseCase $deletePermissionUseCase;

    protected FindPermissionUseCase $findPermissionUseCase;

    protected UpdatePermissionUseCase $updatePermissionUseCase;

    public function __construct(
        FindAllPermissionsUseCase $findAllPermissionsUseCase,
        CreatePermissionUseCase $createPermissionUseCase,
        DeletePermissionUseCase $deletePermissionUseCase,
        FindPermissionUseCase $findPermissionUseCase,
        UpdatePermissionUseCase $updatePermissionUseCase

    ) {
        $this->findAllPermissionsUseCase = $findAllPermissionsUseCase;
        $this->createPermissionUseCase = $createPermissionUseCase;
        $this->deletePermissionUseCase = $deletePermissionUseCase;
        $this->findPermissionUseCase = $findPermissionUseCase;
        $this->updatePermissionUseCase = $updatePermissionUseCase;
    }

    public function index()
    {
        $input = [];
        try {
            $output = $this->findAllPermissionsUseCase->run($input);

            return BaseResponse::successWithContent('Found permissions', HttpCode::OK, $output);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function store(PermissionRequest $request)
    {
        $input = $request->all();

        try {
            $this->createPermissionUseCase->run($input);

            return BaseResponse::success('Permission created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'Permission already exists';

            if ($isAlreadyExistsError) {
                $httpCode = HttpCode::BAD_REQUEST;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function show(string $id)
    {
        $input = [
            'id' => $id,
        ];

        try {
            $output = $this->findPermissionUseCase->run($input);

            return BaseResponse::successWithContent('Permission found', HttpCode::OK, $output);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) {
                $httpCode = HttpCode::BAD_REQUEST;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function update(PermissionRequest $request, string $id)
    {
        $input = $request->all();
        $input['id'] = $id;

        try {
            $this->updatePermissionUseCase->run($input);

            return BaseResponse::success('Permission Updated successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) {
                $httpCode = HttpCode::BAD_REQUEST;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function destroy(string $id)
    {
        $input = [
            'id' => $id,
        ];

        try {
            $this->deletePermissionUseCase->run($input);

            return BaseResponse::success('Permission deleted successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) {
                $httpCode = HttpCode::BAD_REQUEST;
            }

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
