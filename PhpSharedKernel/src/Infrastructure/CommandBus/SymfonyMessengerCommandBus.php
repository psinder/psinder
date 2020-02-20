<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\CommandBus;

use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyMessengerCommandBus implements CommandBus
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
