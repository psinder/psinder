<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Logging;

use Psr\Log\LoggerInterface;

interface LoggerFactory
{
    public function __invoke(string $channel): LoggerInterface;
}
