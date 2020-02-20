<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\QueryBus;

use function Functional\first;
use Sip\Psinder\SharedKernel\Application\Query\Query;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SymfonyMessengerQueryBus implements QueryBus
{
    /** @var MessageBusInterface */
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function execute(Query $query)
    {
        $envelope = $this->bus->dispatch($query);
        /** @var HandledStamp|null $stamp */
        $stamp = first($envelope->all(HandledStamp::class));

        if (!$stamp) {
            throw new \LogicException(sprintf('Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".', \get_class($envelope->getMessage()), \get_class($this), __FUNCTION__));
        }

        return $stamp->getResult();
    }
}
