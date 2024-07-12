<?php

namespace Src\Infra\Factories;

use Bref\Logger\StderrLogger;
use Psr\Log\LogLevel;

class LoggerFactory
{
    private string $level;

    private array $levels;

    public function __construct(string $level)
    {
        $this->level = $level;
        $this->levels = [
            'debug' => new StderrLogger(LogLevel::DEBUG),
            'info' => new StderrLogger(LogLevel::INFO),
            'emergency' => new StderrLogger(LogLevel::EMERGENCY),
            'alert' => new StderrLogger(LogLevel::ALERT),
            'critical' => new StderrLogger(LogLevel::CRITICAL),
            'error' => new StderrLogger(LogLevel::ERROR),
            'warning' => new StderrLogger(LogLevel::WARNING),
            'notice' => new StderrLogger(LogLevel::NOTICE),
        ];
    }

    public function build(): StderrLogger
    {
        return $this->levels[$this->level];
    }
}
