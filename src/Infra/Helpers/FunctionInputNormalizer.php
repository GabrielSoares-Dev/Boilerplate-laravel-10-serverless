<?php

namespace Src\Infra\Helpers;

use Bref\Event\Sns\SnsEvent;
use Bref\Event\Sqs\SqsEvent;

class FunctionInputNormalizer
{
    public static function fromSNS(SnsEvent $event): mixed
    {
        $firstRecordIndex = 0;
        $input = $event->getRecords()[$firstRecordIndex]->getMessage();

        $decodeInputJsonStringIntoObject = json_decode($input);

        $isJson = !is_null($decodeInputJsonStringIntoObject);

        return $isJson ? $decodeInputJsonStringIntoObject : $input;
    }

    public static function fromSQS(SqsEvent $event): mixed
    {
        $firstRecordIndex = 0;
        $input = $event->getRecords()[$firstRecordIndex]->getBody();

        $decodeInputJsonStringIntoObject = json_decode($input);

        $isJson = !is_null($decodeInputJsonStringIntoObject);

        return $isJson ? $decodeInputJsonStringIntoObject : $input;
    }
}
