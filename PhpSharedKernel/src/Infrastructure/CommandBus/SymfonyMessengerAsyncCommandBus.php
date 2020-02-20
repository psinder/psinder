<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\CommandBus;

use Sip\Psinder\SharedKernel\Application\Command\AsyncCommandBus;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyMessengerAsyncCommandBus implements AsyncCommandBus
{
    /** @var MessageBusInterface */
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(Command $command) : void
    {
        $this->bus->dispatch($command);
    }
}
