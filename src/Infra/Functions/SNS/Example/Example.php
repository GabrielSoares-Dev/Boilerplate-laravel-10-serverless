<?php

namespace Src\Infra\Functions\SNS\Example;

use Bref\Context\Context;
use Bref\Event\Sns\SnsEvent;
use Bref\Event\Sns\SnsHandler;
use Src\Application\Services\LoggerServiceInterface;

class ExampleHandler extends SnsHandler
{
    protected LoggerServiceInterface $loggerService;

    public function __construct(LoggerServiceInterface $loggerService)
    {
        $this->loggerService = $loggerService;
    }
    
    public function handleSns(SnsEvent $event, Context $context): void
    {
        foreach ($event->getRecords() as $record) {
            $message = $record->getMessage();

            $this->loggerService->debug("testtt", (object) $message);
        }
    }
}
