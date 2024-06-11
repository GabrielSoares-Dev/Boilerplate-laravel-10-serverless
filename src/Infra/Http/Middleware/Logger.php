<?php

namespace Src\Infra\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Src\Application\Services\LoggerServiceInterface;

class Logger
{
    protected LoggerServiceInterface $loggerService;

    public function __construct(LoggerServiceInterface $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        $this->loggerService->debug('request', (object) $request->all());
        $this->loggerService->debug('response', $response->original);

        return $response;
    }
}
