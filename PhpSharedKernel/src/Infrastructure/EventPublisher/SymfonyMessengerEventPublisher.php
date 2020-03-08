<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\EventPublisher;

use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyMessengerEventPublisher implements EventPublisher
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function publish(Event ...$events) : void
    {
        foreach ($events as $event) {
            $this->bus->dispatch($event);
        }
    }
}
