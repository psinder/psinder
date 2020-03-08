<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure;

use Ds\Set;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;

final class InterceptingEventPublisher implements EventPublisher
{
    /**
     * @var Set<Event>
     */
    private Set $events;

    public function __construct()
    {
        $this->events = new Set();
    }

    public function publish(Event ...$events) : void
    {
        $this->events->add(...$events);
    }

    /**
     * @return Event[]
     */
    public function events() : array
    {
        return [...$this->events];
    }

    public function clear() : void
    {
        $this->events->clear();
    }
}
