<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\QueryBus;

use LogicException;
use Sip\Psinder\SharedKernel\Application\Query\Query;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use function Functional\first;
use function get_class;
use function sprintf;

final class SymfonyMessengerQueryBus implements QueryBus
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @return mixed
     */
    public function execute(Query $query)
    {
        $envelope = $this->bus->dispatch($query);
        /** @var HandledStamp|null $stamp */
        $stamp = first($envelope->all(HandledStamp::class));

        if ($stamp === null) {
            throw new LogicException(sprintf(
                'Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".',
                get_class($envelope->getMessage()),
                static::class,
                __FUNCTION__
            ));
        }

        return $stamp->getResult();
    }
}
