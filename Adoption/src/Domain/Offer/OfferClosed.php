<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

use DateTimeImmutable;
use Sip\Psinder\SharedKernel\Domain\Event;

final class OfferClosed implements Event
{
    /** @var string */
    private $offerId;

    /** @var DateTimeImmutable */
    private $occurredAt;

    public function __construct(string $offerId, DateTimeImmutable $occurredAt)
    {
        $this->offerId    = $offerId;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(OfferId $id) : self
    {
        return new self($id->toScalar(), new DateTimeImmutable());
    }

    public function offerId() : string
    {
        return $this->offerId;
    }

    public function occurredAt() : DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
