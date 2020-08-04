<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Transfer;

use DateTimeImmutable;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\SharedKernel\Domain\Event;

final class TransferScheduled implements Event
{
    private string $id;

    private string $offerId;

    /** @var string[] */
    private array $pet;

    private string $adopterId;

    private DateTimeImmutable $occurredAt;

    /**
     * @param string[] $pet
     */
    public function __construct(
        string $id,
        string $offerId,
        array $pet,
        string $adopterId,
        DateTimeImmutable $occurredAt
    ) {
        $this->id         = $id;
        $this->offerId    = $offerId;
        $this->pet        = $pet;
        $this->adopterId  = $adopterId;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(TransferId $id, OfferId $offerId, Pet $pet, AdopterId $adopterId): self
    {
        return new self(
            $id->toScalar(),
            $offerId->toScalar(),
            $pet->toPayload(),
            $adopterId->toScalar(),
            new DateTimeImmutable()
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function offerId(): string
    {
        return $this->offerId;
    }

    /**
     * @return string[]
     */
    public function pet(): array
    {
        return $this->pet;
    }

    public function adopterId(): string
    {
        return $this->adopterId;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
