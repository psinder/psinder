<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

final class ExecutionContext
{
    private ?string $correlationId;
    private string $appName;

    public function __construct(string $appName)
    {
        $this->correlationId = null;
        $this->appName       = $appName;
    }

    public function init(?string $correlationId) : void
    {
        $this->correlationId = $correlationId;
    }

    public function correlationId() : ?string
    {
        return $this->correlationId;
    }

    public function appName() : string
    {
        return $this->appName;
    }
}
