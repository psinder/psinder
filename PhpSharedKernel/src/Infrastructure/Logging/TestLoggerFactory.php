<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Logging;

use EasyCorp\EasyLog\EasyLogHandler;
use Monolog\Handler\BufferHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class TestLoggerFactory
{
    public function __invoke(string $path): LoggerInterface
    {
        return new Logger('test', [
            new BufferHandler(new EasyLogHandler($path))
        ]);
    }
}
