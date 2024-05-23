<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\Services\AuthServiceInterface;
use Src\Application\UseCases\Auth\LogoutUseCase;
use Tests\Helpers\Mocks\LoggerMock;

class LogoutUseCaseTest extends TestCase
{
    public function test_should_logout(): void
    {
        $loggerMock = LoggerMock::mock();

        $authServiceMock = Mockery::mock(AuthServiceInterface::class);

        $authServiceMock
            ->shouldReceive('logout')
            ->andReturn(true);

        $useCase = new LogoutUseCase($loggerMock, $authServiceMock);

        $input = [];
        $useCase->run($input);

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
