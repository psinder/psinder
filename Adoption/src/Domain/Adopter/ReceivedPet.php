<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Adopter;

use DateTimeImmutable;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\SharedKernel\Domain\Event;

final class ReceivedPet implements Event
{
    /** @var string */
    private $adopterId;

    /** @var string[] */
    private $pet;

    /** @var DateTimeImmutable */
    private $occurredAt;

    /**
     * @param string[] $pet
     */
    public function __construct(string $adopterId, array $pet, DateTimeImmutable $occurredAt)
    {
        $this->adopterId  = $adopterId;
        $this->pet        = $pet;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(AdopterId $adopterId, Pet $pet) : self
    {
        return new self($adopterId->toScalar(), $pet->toPayload(), new DateTimeImmutable());
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
