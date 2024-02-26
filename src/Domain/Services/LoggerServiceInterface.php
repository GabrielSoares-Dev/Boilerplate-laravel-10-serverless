<?php

namespace Src\Domain\Services;

interface LoggerServiceInterface
{
    public function debug(string $message, array $input): void;

    public function info(string $message, array $input): void;

    public function error(string $message, array $input): void;

    public function notice(string $message, array $input): void;

    public function warning(string $message, array $input): void;

    public function critical(string $message, array $input): void;

    public function alert(string $message, array $input): void;

    public function emergency(string $message, array $input): void;
}
