<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function assert;

final class LoggingErrorListenerDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback): ErrorHandler
    {
        $listener     = new LoggingErrorListener($container->get(LoggerInterface::class));
        $errorHandler = $callback();
        assert($errorHandler instanceof ErrorHandler);
        $errorHandler->attachListener($listener);

        return $errorHandler;
    }
}
