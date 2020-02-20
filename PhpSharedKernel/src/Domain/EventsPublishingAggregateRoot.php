<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

trait EventsPublishingAggregateRoot
{
    /** @var Event[] */
    protected $events = [];

    public function publishEvents(EventPublisher $publisher) : void
    {
        $events       = $this->events;
        $this->events = [];

        $publisher->publish(...$events);
    }
}
