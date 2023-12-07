<?php

namespace App\Exceptions;

use Exception;

/**
 * @codeCoverageIgnore
 */
class BusinessException extends Exception
{
    public function __construct($message = '', $statusCode = 500, $code = 0, ?Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
