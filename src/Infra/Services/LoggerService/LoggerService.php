<?php

namespace Src\Infra\Services\LoggerService;

use Src\Application\Services\LoggerServiceInterface;
use Bref\Logger\StderrLogger;
use Psr\Log\LogLevel;

class LoggerService implements LoggerServiceInterface
{
    protected string $context;

    protected StderrLogger $logger;

    public function __construct()
    {
        $this->context = env('APP_NAME');
        $this->logger = new StderrLogger(LogLevel::DEBUG);
    }

    protected function generateMessage(string $message): string
    {
        return "$this->context $message";
    }

    protected function generateMessageWithInput(string $message): string
    {
        return "$this->context $message {input}";
    }

    public function debug(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->debug($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }

    public function info(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->info($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }

    public function error(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->error($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }

    public function notice(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->notice($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }

    public function warning(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->warning($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }

    public function critical(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->critical($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }

    public function alert(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->alert($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }

    public function emergency(string $message, ?object $input = null): void
    {
        $hasInput = !is_null($input);

        $this->logger->emergency($hasInput ? $this->generateMessageWithInput($message) : $this->generateMessage($message), ['input' => (array) $input]);
    }
}
