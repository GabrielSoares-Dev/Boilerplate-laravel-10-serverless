<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\BusinessException;
use App\Exceptions\HttpException;
use App\Services\PermissionServices\CreatePermissionService;
use App\Http\Requests\PermissionRequest;
use App\Helpers\BaseResponse;

/**
 * @codeCoverageIgnore
 */

class PermissionController extends Controller
{

    protected CreatePermissionService $createPermissionService;


    public function __construct(
        CreatePermissionService $createPermissionService
    ) {
        $this->createPermissionService = $createPermissionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(PermissionRequest $request)
    {
        $input = $request->all();

        try {
            $output = $this->createPermissionService->run($input);

            return BaseResponse::success($output['message'], $output['statusCode']);
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
