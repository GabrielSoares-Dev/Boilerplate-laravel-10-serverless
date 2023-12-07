<?php

namespace App\Helpers;

/**
 * @codeCoverageIgnore
 */
class BaseResponse
{
    public static function success($message, $statusCode)
    {
        $response = [
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }

    public static function successWithContent($message, int $statusCode, $content)
    {

        $body = [
            'statusCode' => $statusCode,
            'message' => $message,
            'content' => $content,
        ];

        return response()->json($body, $statusCode);
    }
}
