<?php

namespace Src\Infra\Http\Controllers;

use Src\Application\Exceptions\BusinessException;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Application\UseCases\Permission\FindAllPermissionsUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Http\Requests\PermissionRequest;


class PermissionController extends Controller
{
    protected FindAllPermissionsUseCase $findAllPermissionsUseCase;
    protected CreatePermissionUseCase $createPermissionUseCase;

    public function __construct(
        FindAllPermissionsUseCase $findAllPermissionsUseCase,
        CreatePermissionUseCase $createPermissionUseCase
    ) {
        $this->findAllPermissionsUseCase = $findAllPermissionsUseCase;
        $this->createPermissionUseCase = $createPermissionUseCase;
    }

    public function index()
    {
        $input = [];
        try {
            $output =  $this->findAllPermissionsUseCase->run($input);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    public function destroy(string $id)
    {
    }
}
