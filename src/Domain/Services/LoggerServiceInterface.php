<?php

namespace Src\Domain\Services;

interface LoggerServiceInterface
{
    public function debug(string $message, ?object $input = null): void;

    public function info(string $message, ?object $input = null): void;

    public function error(string $message, ?object $input = null): void;

    public function notice(string $message, ?object $input = null): void;

    public function warning(string $message, ?object $input = null): void;

    public function critical(string $message, ?object $input = null): void;

    public function alert(string $message, ?object $input = null): void;

    public function emergency(string $message, ?object $input = null): void;
}
