<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Transfer;

use DateTimeImmutable;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\SharedKernel\Domain\Event;

final class TransferCompleted implements Event
{
    private string $transferId;

    /** @var string[] */
    private array $pet;

    private string $adopterId;

    private DateTimeImmutable $occurredAt;

    /**
     * @param string[] $pet
     */
    public function __construct(
        string $transferId,
        string $adopterId,
        array $pet,
        DateTimeImmutable $occurredAt
    ) {
        $this->transferId = $transferId;
        $this->pet        = $pet;
        $this->adopterId  = $adopterId;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(TransferId $id, AdopterId $adopterId, Pet $pet) : self
    {
        return new self($id->toScalar(), $adopterId->toScalar(), $pet->toPayload(), new DateTimeImmutable());
    }

    public function transferId() : string
    {
        return $this->transferId;
    }

    public function adopterId() : string
    {
        return $this->adopterId;
    }

    /**
     * @return string[]
     */
    public function pet() : array
    {
        return $this->pet;
    }

    public function occurredAt() : DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
