<?php

namespace Src\Infra\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Src\Application\UseCases\Auth\CheckAuthenticationUseCase;

class Authenticate
{
    protected CheckAuthenticationUseCase $checkAuthenticationUseCase;

    public function __construct(CheckAuthenticationUseCase $checkAuthenticationUseCase)
    {
        $this->checkAuthenticationUseCase = $checkAuthenticationUseCase;
    }

    public function handle(Request $request, Closure $next)
    {
        $input = [];

        $this->checkAuthenticationUseCase->run($input);

        return $next($request);
    }
}
