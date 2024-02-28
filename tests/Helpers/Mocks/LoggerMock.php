<?php

namespace Tests\Helpers\Mocks;

use Src\Domain\Services\LoggerServiceInterface;
use Mockery;

class LoggerMock
{
    public static function mock(): LoggerServiceInterface
    {
        $loggerMock = Mockery::mock(LoggerServiceInterface::class);

        $loggerMock->shouldReceive('debug')->andReturnSelf();

        $loggerMock->shouldReceive('info')->andReturnSelf();

        $loggerMock->shouldReceive('error')->andReturnSelf();

        $loggerMock->shouldReceive('notice')->andReturnSelf();

        $loggerMock->shouldReceive('warning')->andReturnSelf();

        $loggerMock->shouldReceive('critical')->andReturnSelf();

        $loggerMock->shouldReceive('alert')->andReturnSelf();

        $loggerMock->shouldReceive('emergency')->andReturnSelf();

        return $loggerMock;
    }
}
