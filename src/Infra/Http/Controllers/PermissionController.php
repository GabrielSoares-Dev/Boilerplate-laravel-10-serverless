<?php

namespace Src\Infra\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Application\UseCases\Permission\DeletePermissionUseCase;
use Src\Application\UseCases\Permission\FindAllPermissionsUseCase;
use Src\Application\UseCases\Permission\FindPermissionUseCase;
use Src\Application\UseCases\Permission\UpdatePermissionUseCase;
use Src\Domain\Dtos\UseCases\Permission\Create\CreatePermissionUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Permission\Delete\DeletePermissionUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Permission\Find\FindPermissionUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Permission\Update\UpdatePermissionUseCaseInputDto;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\Authorize;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\Permission\PermissionRequest;

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

    public function index(): JsonResponse
    {
        Authorize::hasPermission('read_all_permissions');
        try {
            $output = $this->findAllPermissionsUseCase->run();

            return BaseResponse::successWithContent('Found permissions', HttpCode::OK, $output);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function store(PermissionRequest $request): JsonResponse
    {
        Authorize::hasPermission('create_permission');
        $input = new CreatePermissionUseCaseInputDto(...$request->all());

        try {
            $this->createPermissionUseCase->run($input);

            return BaseResponse::success('Permission created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'Permission already exists';

            if ($isAlreadyExistsError) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function show(int $id): JsonResponse
    {
        Authorize::hasPermission('read_permission');
        $input = new FindPermissionUseCaseInputDto($id);

        try {
            $output = $this->findPermissionUseCase->run($input);

            return BaseResponse::successWithContent('Permission found', HttpCode::OK, $output);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function update(PermissionRequest $request, int $id): JsonResponse
    {
        Authorize::hasPermission('update_permission');
        $name = $request->name;

        $input = new UpdatePermissionUseCaseInputDto($id, $name);

        try {
            $this->updatePermissionUseCase->run($input);

            return BaseResponse::success('Permission Updated successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        Authorize::hasPermission('delete_permission');

        $input = new DeletePermissionUseCaseInputDto($id);

        try {
            $this->deletePermissionUseCase->run($input);

            return BaseResponse::success('Permission deleted successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId)  $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
