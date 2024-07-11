<?php

namespace Src\Infra\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\Dtos\UseCases\Role\Create\CreateRoleUseCaseInputDto;
use Src\Application\Dtos\UseCases\Role\Delete\DeleteRoleUseCaseInputDto;
use Src\Application\Dtos\UseCases\Role\Find\FindRoleUseCaseInputDto;
use Src\Application\Dtos\UseCases\Role\SyncPermissionsWithRole\SyncPermissionsWithRoleUseCaseInputDto;
use Src\Application\Dtos\UseCases\Role\UnsyncPermissionsWithRole\UnsyncPermissionsWithRoleUseCaseInputDto;
use Src\Application\Dtos\UseCases\Role\Update\UpdateRoleUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Services\LoggerServiceInterface;
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
use Src\Infra\Http\Requests\Role\{RoleRequest, SyncPermissionsWithRoleRequest, UnsyncPermissionsWithRoleRequest};

class RoleController extends Controller
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly CreateRoleUseCase $createRoleUseCase,
        protected readonly FindAllRolesUseCase $findAllRolesUseCase,
        protected readonly FindRoleUseCase $findRoleUseCase,
        protected readonly DeleteRoleUseCase $deleteRoleUseCase,
        protected readonly UpdateRoleUseCase $updateRoleUseCase,
        protected readonly SyncPermissionsWithRoleUseCase $syncPermissionsWithRoleUseCase,
        protected readonly UnsyncPermissionsWithRoleUseCase $unsyncPermissionsWithRoleUseCase
    ) {}

    public function index(): JsonResponse
    {
        Authorize::hasPermission('read_all_roles');

        try {

            $this->loggerService->info('START RoleController index');

            $output = $this->findAllRolesUseCase->run();

            $this->loggerService->debug('Output RoleController index', (object) $output);

            $this->loggerService->info('FINISH RoleController index');

            return BaseResponse::successWithContent('Found roles', HttpCode::OK, $output);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $this->loggerService->error('Error RoleController index', $exception);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function store(RoleRequest $request): JsonResponse
    {
        Authorize::hasPermission('create_role');

        $input = new CreateRoleUseCaseInputDto(...$request->all());

        try {

            $this->loggerService->info('START RoleController store');

            $this->loggerService->debug('Input RoleController store', $input);

            $this->createRoleUseCase->run($input);

            $this->loggerService->info('FINISH RoleController store');

            return BaseResponse::success('Role created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'Role already exists';

            if ($isAlreadyExistsError) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error RoleController store', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function show(int $id): JsonResponse
    {
        Authorize::hasPermission('read_role');

        $input = new FindRoleUseCaseInputDto($id);

        try {

            $this->loggerService->info('START RoleController show');

            $this->loggerService->debug('Input RoleController show', $input);

            $output = $this->findRoleUseCase->run($input);

            $this->loggerService->debug('Output RoleController show', $output);

            $this->loggerService->info('FINISH RoleController show');

            return BaseResponse::successWithContent('Role found', HttpCode::OK, $output);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error RoleController show', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function update(RoleRequest $request, int $id): JsonResponse
    {
        Authorize::hasPermission('update_role');

        $input = new UpdateRoleUseCaseInputDto($id, ...$request->all());

        try {

            $this->loggerService->info('START RoleController update');

            $this->loggerService->debug('Input RoleController update', $input);

            $this->updateRoleUseCase->run($input);

            $this->loggerService->info('FINISH RoleController update');

            return BaseResponse::success('Role Updated successfully', HttpCode::OK);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId)  $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error RoleController update', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        Authorize::hasPermission('delete_role');

        $input = new DeleteRoleUseCaseInputDto($id);

        try {

            $this->loggerService->info('START RoleController destroy');

            $this->loggerService->debug('Input RoleController destroy', $input);

            $this->deleteRoleUseCase->run($input);

            $this->loggerService->info('FINISH RoleController destroy');

            return BaseResponse::success('Role deleted successfully', HttpCode::OK);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error RoleController destroy', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function syncPermissions(SyncPermissionsWithRoleRequest $request): JsonResponse
    {
        Authorize::hasPermission('sync_role_with_permissions');

        $input = new SyncPermissionsWithRoleUseCaseInputDto(...$request->all());

        try {

            $this->loggerService->info('START RoleController syncPermissions');

            $this->loggerService->debug('Input RoleController syncPermissions', $input);

            $this->syncPermissionsWithRoleUseCase->run($input);

            $this->loggerService->info('FINISH RoleController syncPermissions');

            return BaseResponse::success('Role sync successfully', HttpCode::OK);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidPermission = $errorMessage === 'Invalid permission';

            $isInvalidRole = $errorMessage === 'Invalid role';

            if ($isInvalidPermission || $isInvalidRole) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error RoleController syncPermissions', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function unsyncPermissions(UnsyncPermissionsWithRoleRequest $request): JsonResponse
    {
        Authorize::hasPermission('unsync_role_with_permissions');

        $input = new UnsyncPermissionsWithRoleUseCaseInputDto(...$request->all());

        try {

            $this->loggerService->info('START RoleController unsyncPermissions');

            $this->loggerService->debug('Input RoleController unsyncPermissions', $input);

            $this->unsyncPermissionsWithRoleUseCase->run($input);

            $this->loggerService->info('FINISH RoleController unsyncPermissions');

            return BaseResponse::success('Role unsync successfully', HttpCode::OK);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidPermission = $errorMessage === 'Invalid permission';

            $isInvalidRole = $errorMessage === 'Invalid role';

            if ($isInvalidPermission || $isInvalidRole) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error RoleController unsyncPermissions', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
