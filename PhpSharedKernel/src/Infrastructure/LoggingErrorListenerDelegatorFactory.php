<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class LoggingErrorListenerDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback) : ErrorHandler
    {
        $listener = new LoggingErrorListener($container->get(LoggerInterface::class));
        /** @var ErrorHandler $errorHandler */
        $errorHandler = $callback();
        $errorHandler->attachListener($listener);

        return $errorHandler;
    }
}
