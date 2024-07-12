<?php

namespace Src\Infra\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Src\Application\Services\LoggerServiceInterface;

class Logger
{
    public function __construct(private readonly LoggerServiceInterface $loggerService) {}

    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        $this->loggerService->debug('request', (object) $request->all());
        $this->loggerService->debug('response', (object) $response->original);

        return $response;
    }
}
