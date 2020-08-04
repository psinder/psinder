<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Logging;

use Monolog\Processor\ProcessorInterface;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\ExecutionContext;

final class ExecutionContextProcessor implements ProcessorInterface
{
    private ExecutionContext $context;

    public function __construct(ExecutionContext $context)
    {
        $this->context = $context;
    }

    /**
     * @param mixed[] $record
     * @return mixed[]
     */
    public function __invoke(array $record) : array
    {
        $record['extra']['correlation_id'] = $this->context->correlationId();
        return $record;
    }
}
