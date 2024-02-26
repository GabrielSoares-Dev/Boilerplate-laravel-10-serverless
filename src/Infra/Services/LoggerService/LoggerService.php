<?php

namespace Src\Infra\Services\LoggerService;

use Src\Domain\Services\LoggerServiceInterface;
use Illuminate\Support\Facades\Log;

class LoggerService implements LoggerServiceInterface
{
    protected string $context = env('APP_NAME');

    protected function generateMessage(string $message): string
    {
        return "$this->context $message";
    }

    public function debug(string $message, array $input): void
    {
        Log::debug($this->generateMessage($message), $input);
    }

    public function info(string $message, array $input): void
    {
        Log::info($this->generateMessage($message), $input);
    }

    public function error(string $message, array $input): void
    {
        Log::error($this->generateMessage($message), $input);
    }

    public function notice(string $message, array $input): void
    {
        Log::notice($this->generateMessage($message), $input);
    }

    public function warning(string $message, array $input): void
    {
        Log::warning($this->generateMessage($message), $input);
    }

    public function critical(string $message, array $input): void
    {
        Log::critical($this->generateMessage($message), $input);
    }

    public function alert(string $message, array $input): void
    {
        Log::alert($this->generateMessage($message), $input);
    }

    public function emergency(string $message, array $input): void
    {
        Log::alert($this->generateMessage($message), $input);
    }
}
