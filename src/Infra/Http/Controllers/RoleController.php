<?php

namespace Src\Infra\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\Exceptions\BusinessException;
use Src\Application\UseCases\Role\CreateRoleUseCase;
use Src\Application\UseCases\Role\DeleteRoleUseCase;
use Src\Application\UseCases\Role\FindAllRolesUseCase;
use Src\Application\UseCases\Role\FindRoleUseCase;
use Src\Application\UseCases\Role\SyncPermissionsWithRoleUseCase;
use Src\Application\UseCases\Role\UnsyncPermissionsWithRoleUseCase;
use Src\Application\UseCases\Role\UpdateRoleUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\Authorize;
use Src\Infra\Helpers\BaseResponse;
use Src\Domain\Dtos\UseCases\Role\Create\CreateRoleUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Role\Find\FindRoleUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Role\Update\UpdateRoleUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Role\Delete\DeleteRoleUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Role\SyncPermissionsWithRole\SyncPermissionsWithRoleUseCaseInputDto;
use Src\Domain\Dtos\UseCases\Role\UnsyncPermissionsWithRole\UnsyncPermissionsWithRoleUseCaseInputDto;
use Src\Infra\Http\Requests\Role\{
    RoleRequest,
    SyncPermissionsWithRoleRequest,
    UnsyncPermissionsWithRoleRequest
};

class RoleController extends Controller
{
    protected CreateRoleUseCase $createRoleUseCase;

    protected DeleteRoleUseCase $deleteRoleUseCase;

    protected UpdateRoleUseCase $updateRoleUseCase;

    protected FindAllRolesUseCase $findAllRolesUseCase;

    protected FindRoleUseCase $findRoleUseCase;

    protected SyncPermissionsWithRoleUseCase $syncPermissionsWithRoleUseCase;

    protected UnsyncPermissionsWithRoleUseCase $unsyncPermissionsWithRoleUseCase;

    public function __construct(
        CreateRoleUseCase $createRoleUseCase,
        FindAllRolesUseCase $findAllRolesUseCase,
        FindRoleUseCase $findRoleUseCase,
        DeleteRoleUseCase $deleteRoleUseCase,
        UpdateRoleUseCase $updateRoleUseCase,
        SyncPermissionsWithRoleUseCase $syncPermissionsWithRoleUseCase,
        UnsyncPermissionsWithRoleUseCase $unsyncPermissionsWithRoleUseCase
    ) {
        $this->createRoleUseCase = $createRoleUseCase;
        $this->findAllRolesUseCase = $findAllRolesUseCase;
        $this->findRoleUseCase = $findRoleUseCase;
        $this->deleteRoleUseCase = $deleteRoleUseCase;
        $this->updateRoleUseCase = $updateRoleUseCase;
        $this->syncPermissionsWithRoleUseCase = $syncPermissionsWithRoleUseCase;
        $this->unsyncPermissionsWithRoleUseCase = $unsyncPermissionsWithRoleUseCase;
    }

    public function index(): JsonResponse
    {
        Authorize::hasPermission('read_all_roles');

        try {
            $output = $this->findAllRolesUseCase->run();

            return BaseResponse::successWithContent('Found roles', HttpCode::OK, $output);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function store(RoleRequest $request): JsonResponse
    {
        Authorize::hasPermission('create_role');

        $input = new CreateRoleUseCaseInputDto(...$request->all());

        try {
            $this->createRoleUseCase->run($input);

            return BaseResponse::success('Role created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'Role already exists';

            if ($isAlreadyExistsError) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function show(int $id): JsonResponse
    {
        Authorize::hasPermission('read_role');
        $input = new FindRoleUseCaseInputDto($id);

        try {
            $output = $this->findRoleUseCase->run($input);

            return BaseResponse::successWithContent('Role found', HttpCode::OK, $output);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function update(RoleRequest $request, int $id): JsonResponse
    {
        Authorize::hasPermission('update_role');

        $input = new UpdateRoleUseCaseInputDto($id, ...$request->all());

        try {
            $this->updateRoleUseCase->run($input);

            return BaseResponse::success('Role Updated successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId)  $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        Authorize::hasPermission('delete_role');

        $input = new DeleteRoleUseCaseInputDto($id);

        try {
            $this->deleteRoleUseCase->run($input);

            return BaseResponse::success('Role deleted successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function syncPermissions(SyncPermissionsWithRoleRequest $request): JsonResponse
    {
        Authorize::hasPermission('sync_role_with_permissions');
        $input = new SyncPermissionsWithRoleUseCaseInputDto(...$request->all());

        try {
            $this->syncPermissionsWithRoleUseCase->run($input);

            return BaseResponse::success('Role sync successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidPermission = $errorMessage === 'Invalid permission';

            $isInvalidRole = $errorMessage === 'Invalid role';

            if ($isInvalidPermission || $isInvalidRole) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function unsyncPermissions(UnsyncPermissionsWithRoleRequest $request): JsonResponse
    {
        Authorize::hasPermission('unsync_role_with_permissions');
        $input = new UnsyncPermissionsWithRoleUseCaseInputDto(...$request->all());

        try {
            $this->unsyncPermissionsWithRoleUseCase->run($input);

            return BaseResponse::success('Role unsync successfully', HttpCode::OK);
        } catch (BusinessException $exception) {
            $errorMessage = $exception->getMessage();
            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidPermission = $errorMessage === 'Invalid permission';

            $isInvalidRole = $errorMessage === 'Invalid role';

            if ($isInvalidPermission || $isInvalidRole) $httpCode = HttpCode::BAD_REQUEST;

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
