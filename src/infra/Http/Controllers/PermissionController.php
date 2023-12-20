<?php

namespace Src\Infra\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Exceptions\HttpException;
use App\Helpers\BaseResponse;
use Src\Infra\Http\Requests\PermissionRequest;
use Src\Application\UseCases\Permission\CreatePermissionUseCase;
use Src\Domain\Enums\HttpCode;
use Illuminate\Http\Request;

/**
 * @codeCoverageIgnore
 */
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
        //
    }


    public function store(PermissionRequest $request)
    {
        $input = $request->all();

        try {
            $output = $this->createPermissionUseCase->run($input);
           
            return BaseResponse::success('Permission created successfully', HttpCode::CREATED);
        } catch (BusinessException $exception) {
            throw new HttpException($exception->getMessage(), $exception->getStatusCode() ?? 500);
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
