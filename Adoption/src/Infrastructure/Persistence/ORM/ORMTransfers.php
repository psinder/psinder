<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Sip\Psinder\Adoption\Domain\Transfer\Transfer;
use Sip\Psinder\Adoption\Domain\Transfer\TransferId;
use Sip\Psinder\Adoption\Domain\Transfer\TransferNotFound;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\ORMCollection;
use Throwable;

use function assert;

final class ORMTransfers implements Transfers
{
    private ORMCollection $collection;

    public function __construct(EntityManagerInterface $entityManager, EventPublisher $eventPublisher)
    {
        $this->collection = new ORMCollection(
            $entityManager,
            $eventPublisher,
            Transfer::class,
            static fn (TransferId $id): Throwable => TransferNotFound::forId($id)
        );
    }

    public function create(Transfer $transfer): void
    {
        $this->collection->create($transfer);
    }

    /** @throws TransferNotFound */
    public function update(Transfer $transfer): void
    {
        $this->collection->update($transfer);
    }

    /** @throws TransferNotFound */
    public function get(TransferId $id): Transfer
    {
        $transfer = $this->collection->get($id);

        assert($transfer instanceof Transfer);

        return $transfer;
    }

    public function exists(TransferId $id): bool
    {
        return $this->collection->exists($id);
    }
}
