<?php

namespace App\Exceptions;

use Exception;

/**
 * @codeCoverageIgnore
 */
class HttpException extends Exception
{
    public function render()
    {
        return response()->json([
            'statusCode' => $this->getCode(),
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
