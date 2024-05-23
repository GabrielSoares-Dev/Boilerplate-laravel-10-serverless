<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Services\AuthServiceInterface;
use Src\Application\UseCases\Auth\CheckAuthenticationUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class CheckAuthenticationUseCaseTest extends TestCase
{
    public function test_should_authenticated(): void
    {
        $loggerMock = LoggerMock::mock();

        $authServiceMock = Mockery::mock(AuthServiceInterface::class);

        $authServiceMock
            ->shouldReceive('validateToken')
            ->andReturn(true);

        $input = [];

        $useCase = new CheckAuthenticationUseCase($loggerMock, $authServiceMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_unauthorized(): void
    {
        $loggerMock = LoggerMock::mock();

        $authServiceMock = Mockery::mock(AuthServiceInterface::class);

        $authServiceMock
            ->shouldReceive('validateToken')
            ->andReturn(false);

        $input = [];

        $useCase = new CheckAuthenticationUseCase($loggerMock, $authServiceMock);

        $this->expectExceptionMessage('Unauthorized');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
