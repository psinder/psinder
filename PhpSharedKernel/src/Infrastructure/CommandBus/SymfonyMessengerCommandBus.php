<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\CommandBus;

use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyMessengerCommandBus implements CommandBus
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(Command $command) : void
    {
        try {
            $this->bus->dispatch($command);
        } catch (HandlerFailedException $e) {
            $cause = $e->getPrevious();
            if ($cause !== null) {
                throw $cause;
            }
        }
    }
}
