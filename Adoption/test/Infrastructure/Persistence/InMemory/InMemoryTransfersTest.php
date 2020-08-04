<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryTransfers;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransfersTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class InMemoryTransfersTest extends TestCase
{
    use TransfersTest;
    use EventsInterceptingIsolatedTest;

    private Transfers $transfers;

    public function setUp(): void
    {
        $this->transfers = new InMemoryTransfers($this->eventPublisher());
    }

    protected function transfers(): Transfers
    {
        return $this->transfers;
    }

    protected function context(): TestCase
    {
        return $this;
    }
}
