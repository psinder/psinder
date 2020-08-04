<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Logging;

use EasyCorp\EasyLog\EasyLogHandler;
use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class TestLoggerFactory implements LoggerFactory
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function __invoke(string $channel): LoggerInterface
    {
        return new Logger($channel, [new BufferHandler(new EasyLogHandler($this->path))]);
    }
}
