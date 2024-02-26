<?php

namespace Src\Infra\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * @codeCoverageIgnore
 */
class BaseResponse
{
    public static function success(string $message, int $statusCode): JsonResponse
    {
        $response = [
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }

    public static function successWithContent(string $message, int $statusCode, mixed $content): JsonResponse
    {

        $body = [
            'statusCode' => $statusCode,
            'message' => $message,
            'content' => $content,
        ];

        return response()->json($body, $statusCode);
    }
}
