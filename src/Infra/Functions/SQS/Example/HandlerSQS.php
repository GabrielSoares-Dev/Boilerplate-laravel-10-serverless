<?php

namespace Src\Infra\Functions\SQS\Example;

use Bref\Context\Context;
use Bref\Event\Sqs\SqsEvent;
use Bref\Event\Sqs\SqsHandler;
use Src\Application\Services\LoggerServiceInterface;
use Src\Infra\Helpers\FunctionInputNormalizer;

class HandlerSQS extends SqsHandler
{
    public function __construct(private readonly LoggerServiceInterface $loggerService) {}

    public function handleSqs(SqsEvent $event, Context $context): void
    {
        $this->loggerService->debug('event', (object) $event);
        $this->loggerService->debug('context', (object) $context);

        $input = FunctionInputNormalizer::fromSQS($event);
        $this->loggerService->debug('input', (object) $input);
    }
}
