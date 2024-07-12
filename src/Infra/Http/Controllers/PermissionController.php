<?php

namespace Src\Infra\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Application\Dtos\UseCases\Permission\Create\CreatePermissionUseCaseInputDto;
use Src\Application\Dtos\UseCases\Permission\Delete\DeletePermissionUseCaseInputDto;
use Src\Application\Dtos\UseCases\Permission\Find\FindPermissionUseCaseInputDto;
use Src\Application\Dtos\UseCases\Permission\Update\UpdatePermissionUseCaseInputDto;
use Src\Application\Exceptions\BusinessException;
use Src\Application\Services\LoggerServiceInterface;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Application\UseCases\Permission\DeletePermissionUseCase;
use Src\Application\UseCases\Permission\FindAllPermissionsUseCase;
use Src\Application\UseCases\Permission\FindPermissionUseCase;
use Src\Application\UseCases\Permission\UpdatePermissionUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Domain\Enums\Permission;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\Authorize;
use Src\Infra\Helpers\BaseResponse;
use Src\Infra\Http\Requests\Permission\PermissionRequest;

class PermissionController extends Controller
{
    public function __construct(
        protected readonly LoggerServiceInterface $loggerService,
        protected readonly FindAllPermissionsUseCase $findAllPermissionsUseCase,
        protected readonly CreatePermissionUseCase $createPermissionUseCase,
        protected readonly DeletePermissionUseCase $deletePermissionUseCase,
        protected readonly FindPermissionUseCase $findPermissionUseCase,
        protected readonly UpdatePermissionUseCase $updatePermissionUseCase
    ) {}

    public function index(): JsonResponse
    {
        Authorize::hasPermission(Permission::READ_ALL_PERMISSIONS);

        try {

            $this->loggerService->info('START PermissionController index');

            $output = $this->findAllPermissionsUseCase->run();

            $this->loggerService->debug('Output PermissionController index', (object) $output);

            $this->loggerService->info('FINISH PermissionController index');

            return BaseResponse::successWithContent('Found permissions', HttpCode::OK, $output);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $this->loggerService->error('Error PermissionController index', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function store(PermissionRequest $request): JsonResponse
    {
        Authorize::hasPermission(Permission::CREATE_PERMISSION);

        $input = new CreatePermissionUseCaseInputDto(...$request->all());

        try {

            $this->loggerService->info('START PermissionController store');

            $this->loggerService->debug('Input PermissionController store', $input);

            $this->createPermissionUseCase->run($input);

            $this->loggerService->info('FINISH PermissionController store');

            return BaseResponse::success('Permission created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isAlreadyExistsError = $errorMessage === 'Permission already exists';

            if ($isAlreadyExistsError) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error PermissionController store', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function show(int $id): JsonResponse
    {
        Authorize::hasPermission(Permission::READ_PERMISSION);

        $input = new FindPermissionUseCaseInputDto($id);

        try {

            $this->loggerService->info('START PermissionController show');

            $this->loggerService->debug('Input PermissionController show', $input);

            $output = $this->findPermissionUseCase->run($input);

            $this->loggerService->debug('Output PermissionController show', $output);

            $this->loggerService->info('FINISH PermissionController show');

            return BaseResponse::successWithContent('Permission found', HttpCode::OK, $output);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error PermissionController show', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function update(PermissionRequest $request, int $id): JsonResponse
    {
        Authorize::hasPermission(Permission::UPDATE_PERMISSION);

        $name = $request->input('name');

        $input = new UpdatePermissionUseCaseInputDto($id, $name);

        try {

            $this->loggerService->info('START PermissionController update');

            $this->loggerService->debug('Input PermissionController update', $input);

            $this->updatePermissionUseCase->run($input);

            $this->loggerService->info('FINISH PermissionController update');

            return BaseResponse::success('Permission Updated successfully', HttpCode::OK);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId) $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error PermissionController update', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        Authorize::hasPermission(Permission::DELETE_PERMISSION);

        $input = new DeletePermissionUseCaseInputDto($id);

        try {

            $this->loggerService->info('START PermissionController destroy');

            $this->loggerService->debug('Input PermissionController destroy', $input);

            $this->deletePermissionUseCase->run($input);

            $this->loggerService->info('FINISH PermissionController destroy');

            return BaseResponse::success('Permission deleted successfully', HttpCode::OK);
        } catch (BusinessException $exception) {

            $errorMessage = $exception->getMessage();

            $httpCode = HttpCode::INTERNAL_SERVER_ERROR;

            $isInvalidId = $errorMessage === 'Invalid id';

            if ($isInvalidId)  $httpCode = HttpCode::BAD_REQUEST;

            $this->loggerService->error('Error PermissionController destroy', (object) ['message' => $errorMessage]);

            throw new HttpException($errorMessage, $httpCode);
        }
    }
}
