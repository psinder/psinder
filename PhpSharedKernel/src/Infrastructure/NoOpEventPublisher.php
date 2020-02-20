<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure;

use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;

final class NoOpEventPublisher implements EventPublisher
{
    public function publish(Event ...$events) : void
    {
    }
}
