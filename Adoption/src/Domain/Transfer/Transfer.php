<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Transfer;

use RuntimeException;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\SharedKernel\Domain\AggregateRoot;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventsPublishingAggregateRoot;

final class Transfer implements AggregateRoot
{
    use EventsPublishingAggregateRoot;

    private const COMPLETED = true;
    private const SCHEDULED = false;

    private TransferId $id;
    private OfferId $offerId;
    private Pet $pet;
    private AdopterId $adopterId;
    private bool $completed;

    /**
     * @param Event[] $events
     */
    private function __construct(
        TransferId $id,
        OfferId $offerId,
        Pet $pet,
        AdopterId $adopterId,
        bool $completed,
        array $events = []
    ) {
        $this->id        = $id;
        $this->offerId   = $offerId;
        $this->pet       = $pet;
        $this->adopterId = $adopterId;
        $this->events    = $events;
        $this->completed = $completed;
    }

    public static function schedule(TransferId $id, OfferId $offerId, Pet $pet, AdopterId $adopterId) : self
    {
        return new self(
            $id,
            $offerId,
            $pet,
            $adopterId,
            self::SCHEDULED,
            [TransferScheduled::occur($id, $offerId, $pet, $adopterId)]
        );
    }

    public function id() : TransferId
    {
        return $this->id;
    }

    public function offerId() : OfferId
    {
        return $this->offerId;
    }

    public function pet() : Pet
    {
        return $this->pet;
    }

    public function adopterId() : AdopterId
    {
        return $this->adopterId;
    }

    public function complete() : void
    {
        if ($this->completed) {
            throw new RuntimeException('Already completed');
        }

        $this->completed = self::COMPLETED;

        $this->events[] = TransferCompleted::occur($this->id, $this->adopterId, $this->pet);
    }

    public function isCompleted() : bool
    {
        return $this->completed === self::COMPLETED;
    }
}
