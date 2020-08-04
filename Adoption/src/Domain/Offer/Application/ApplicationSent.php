<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer\Application;

use DateTimeImmutable;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\SharedKernel\Domain\Event;

final class ApplicationSent implements Event
{
    private string $adopterId;

    private string $offerId;

    private DateTimeImmutable $occurredAt;

    public function __construct(string $adopterId, string $offerId, DateTimeImmutable $occurredAt)
    {
        $this->adopterId  = $adopterId;
        $this->offerId    = $offerId;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(AdopterId $adopterId, OfferId $offerId): self
    {
        return new self($adopterId->toScalar(), $offerId->toScalar(), new DateTimeImmutable());
    }

    public function adopterId(): string
    {
        return $this->adopterId;
    }

    public function offerId(): string
    {
        return $this->offerId;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
