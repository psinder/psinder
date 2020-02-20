<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;

interface RequestPayloadTargetDTOResolver
{
    public function resolve(ServerRequestInterface $request) : ?string;
}
