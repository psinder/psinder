<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;

final class FixedRequestPayloadTargetDTOResolver implements RequestPayloadTargetDTOResolver
{
    private string $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function resolve(ServerRequestInterface $request) : ?string
    {
        return $this->class;
    }
}
