<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Logging;

use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\ExecutionContext;

final class LoggerFactory
{
    private int $level;
    private ExecutionContext $executionContext;

    public function __construct(ExecutionContext $executionContext, int $level = Logger::DEBUG)
    {
        $this->level   = $level;
        $this->executionContext = $executionContext;
    }

    public function __invoke(string $channel): LoggerInterface
    {
        $handler = new StreamHandler('php://stdout', $this->level);
        $handler->setFormatter(new LogstashFormatter(
            $this->executionContext->appName()
        ));
        $handler->pushProcessor(new ExecutionContextProcessor(
            $this->executionContext
        ));
        return new Logger($channel, [$handler]);
    }
}
