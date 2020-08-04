<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure;

use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;

use function array_push;

final class InterceptingEventPublisher implements EventPublisher
{
    /** @var Event[] */
    private array $events;

    public function __construct()
    {
        $this->events = [];
    }

    public function publish(Event ...$events): void
    {
        array_push($this->events, ...$events);
    }

    /**
     * @return Event[]
     */
    public function events(): array
    {
        return $this->events;
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
