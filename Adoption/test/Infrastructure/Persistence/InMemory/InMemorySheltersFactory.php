<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryShelters;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\NoOpEventPublisher;

final class InMemorySheltersFactory
{
    public static function create(?EventPublisher $eventPublisher = null) : InMemoryShelters
    {
        return new InMemoryShelters($eventPublisher ?? new NoOpEventPublisher());
    }
}
