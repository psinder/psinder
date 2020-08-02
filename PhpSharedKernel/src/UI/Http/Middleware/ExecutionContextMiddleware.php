<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ExecutionContextMiddleware implements MiddlewareInterface
{
    private ExecutionContext $context;

    public function __construct(ExecutionContext $context)
    {
        $this->context = $context;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $correlationId = $request->getHeader('Correlation-Id')[0] ?? null;
        $this->context->init($correlationId);

        return $handler->handle($request);
    }
}
