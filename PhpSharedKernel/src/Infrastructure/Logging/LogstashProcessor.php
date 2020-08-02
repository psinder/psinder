<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Logging;

use Monolog\Processor\ProcessorInterface;

final class LogstashProcessor implements ProcessorInterface
{
    public function __invoke(array $records)
    {
        // TODO: Implement __invoke() method.
    }
}
