<?php

declare(strict_types = 1);

namespace Sip\Psinder\SharedKernel\Infrastructure;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class LoggingErrorListener
{
    /**
     * Log format for messages:
     *
     * STATUS [METHOD] path: message
     */
    private const LOG_FORMAT = '%d [%s] %s: %s';

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(\Throwable $error, ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->logger->error(
            sprintf(
                self::LOG_FORMAT,
                $response->getStatusCode(),
                $request->getMethod(),
                (string) $request->getUri(),
                $error->getMessage()
            ),
            [
                'exception' => $error->getTraceAsString()
            ]
        );
    }
}
