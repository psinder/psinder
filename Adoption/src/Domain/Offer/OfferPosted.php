<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

use DateTimeImmutable;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\SharedKernel\Domain\Event;

final class OfferPosted implements Event
{
    private string $shelterId;

    private string $offerId;

    /** @var string[] */
    private array $pet;

    private DateTimeImmutable $occurredAt;

    /**
     * @param string[] $pet
     */
    public function __construct(
        string $offerId,
        string $shelterId,
        array $pet,
        DateTimeImmutable $occurredAt
    ) {
        $this->shelterId  = $shelterId;
        $this->offerId    = $offerId;
        $this->pet        = $pet;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(OfferId $id, ShelterId $shelterId, Pet $pet) : self
    {
        return new self(
            $id->toScalar(),
            $shelterId->toScalar(),
            $pet->toPayload(),
            new DateTimeImmutable()
        );
    }

    public function offerId() : string
    {
        return $this->offerId;
    }

    public function shelterId() : string
    {
        return $this->shelterId;
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
