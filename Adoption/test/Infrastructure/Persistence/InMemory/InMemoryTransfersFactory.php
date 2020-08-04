<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryTransfers;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\NoOpEventPublisher;

final class InMemoryTransfersFactory
{
    public static function create(?EventPublisher $eventPublisher = null): InMemoryTransfers
    {
        return new InMemoryTransfers($eventPublisher ?? new NoOpEventPublisher());
    }
}
