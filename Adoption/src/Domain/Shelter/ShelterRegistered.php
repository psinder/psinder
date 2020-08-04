<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Shelter;

use DateTimeImmutable;
use Sip\Psinder\SharedKernel\Domain\Address;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Event;

final class ShelterRegistered implements Event
{
    private string $shelterId;

    private string $name;

    /** @var string[] */
    private array $address;

    private string $email;

    private DateTimeImmutable $occurredAt;

    /**
     * @param string[] $address
     */
    public function __construct(
        string $shelterId,
        string $name,
        string $email,
        array $address,
        DateTimeImmutable $occurredAt
    ) {
        $this->shelterId  = $shelterId;
        $this->name       = $name;
        $this->address    = $address;
        $this->email      = $email;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(
        ShelterId $shelterId,
        ShelterName $name,
        Email $email,
        Address $address
    ): self {
        return new self(
            $shelterId->toScalar(),
            $name->toString(),
            $email->toString(),
            $address->toArray(),
            new DateTimeImmutable()
        );
    }

    public function shelterId(): string
    {
        return $this->shelterId;
    }

    public function name(): string
    {
        return $this->name;
    }

    /** @return string[] */
    public function address(): array
    {
        return $this->address;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
