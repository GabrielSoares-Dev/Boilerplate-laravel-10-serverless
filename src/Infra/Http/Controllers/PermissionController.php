<?php

namespace Src\Infra\Http\Controllers;

use Src\Application\Exceptions\BusinessException;
use Src\Infra\Exceptions\HttpException;
use Src\Infra\Helpers\BaseResponse;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Domain\Enums\HttpCode;
use Src\Infra\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;


class PermissionController extends Controller
{
    protected CreatePermissionUseCase $createPermissionUseCase;

    public function __construct(
        CreatePermissionUseCase $createPermissionUseCase
    ) {
        $this->createPermissionUseCase = $createPermissionUseCase;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
