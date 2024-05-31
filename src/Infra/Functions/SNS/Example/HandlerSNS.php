<?php

namespace Src\Infra\Functions\SNS\Example;

use Bref\Context\Context;
use Bref\Event\Sns\SnsEvent;
use Bref\Event\Sns\SnsHandler;
use Src\Application\Services\LoggerServiceInterface;
use Src\Infra\Helpers\FunctionInputNormalizer;

class HandlerSNS extends SnsHandler
{
    protected LoggerServiceInterface $loggerService;

    public function __construct(LoggerServiceInterface $loggerService)
    {
        $this->loggerService = $loggerService;
    }

    public function handleSns(SnsEvent $event, Context $context): void
    {
        $this->loggerService->debug('event', (object) $event);
        $this->loggerService->debug('context', (object) $context);

        $input = FunctionInputNormalizer::fromSNS($event);
        $this->loggerService->debug('input', (object) $input);
    }
}
