<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Domain\Transfer\Transfer;
use Sip\Psinder\Adoption\Domain\Transfer\TransferId;
use Sip\Psinder\Adoption\Domain\Transfer\TransferNotFound;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;

use function array_key_exists;

final class InMemoryTransfers implements Transfers
{
    /** @var Transfer[] */
    private array $transfers;
    private EventPublisher $eventPublisher;

    public function __construct(EventPublisher $eventPublisher)
    {
        $this->transfers      = [];
        $this->eventPublisher = $eventPublisher;
    }

    /** @throws TransferNotFound */
    public function get(TransferId $id): Transfer
    {
        $transfer = $this->transfers[$id->toScalar()] ?? null;

        if ($transfer === null) {
            throw TransferNotFound::forId($id);
        }

        return $transfer;
    }

    public function create(Transfer $transfer): void
    {
        $this->transfers[$transfer->id()->toScalar()] = $transfer;

        $transfer->publishEvents($this->eventPublisher);
    }

    public function update(Transfer $transfer): void
    {
        $exists = array_key_exists($transfer->id()->toScalar(), $this->transfers);

        if (! $exists) {
            throw TransferNotFound::forId($transfer->id());
        }

        $this->transfers[$transfer->id()->toScalar()] = $transfer;

        $transfer->publishEvents($this->eventPublisher);
    }
}
