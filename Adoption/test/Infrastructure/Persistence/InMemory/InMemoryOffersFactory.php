<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryOffers;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\NoOpEventPublisher;

final class InMemoryOffersFactory
{
    public static function create(?EventPublisher $eventPublisher = null) : InMemoryOffers
    {
        return new InMemoryOffers($eventPublisher ?? new NoOpEventPublisher());
    }
}
