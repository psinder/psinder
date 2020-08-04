<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryAdopters;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\NoOpEventPublisher;

final class InMemoryAdoptersFactory
{
    public static function create(?EventPublisher $eventPublisher = null): InMemoryAdopters
    {
        return new InMemoryAdopters($eventPublisher ?? new NoOpEventPublisher());
    }
}
