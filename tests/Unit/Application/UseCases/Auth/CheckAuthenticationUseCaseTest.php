<?php

namespace Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\Auth\CheckAuthenticationUseCase;
use Src\Domain\Services\AuthServiceInterface;

class CheckAuthenticationUseCaseTest extends TestCase
{
    public function test_should_authenticated(): void
    {
        $authServiceMock = Mockery::mock(AuthServiceInterface::class);

        $authServiceMock
            ->shouldReceive('validateToken')
            ->andReturn(true);

        $input = [];

        $useCase = new CheckAuthenticationUseCase($authServiceMock);

        $useCase->run($input);

        $this->assertTrue(true);
    }

    public function test_should_unauthorized(): void
    {
        $authServiceMock = Mockery::mock(AuthServiceInterface::class);

        $authServiceMock
            ->shouldReceive('validateToken')
            ->andReturn(false);

        $input = [];

        $useCase = new CheckAuthenticationUseCase($authServiceMock);

        $this->expectExceptionMessage('Unauthorized');

        $useCase->run($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
