<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

use Assert\Assertion;
use DateTimeImmutable;

final class Birthdate
{
    private DateTimeImmutable $dateTime;

    private function __construct(DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public static function fromString(string $birthDate): self
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $birthDate);

        Assertion::notSame(false, $date, 'Invalid birthdate');

        return new self($date);
    }

    public static function fromDateTimeImmutable(DateTimeImmutable $birthDate): self
    {
        return new self($birthDate);
    }

    public function age(): int
    {
        return (new DateTimeImmutable())->diff($this->dateTime)->y;
    }

    public function toString(): string
    {
        return $this->dateTime->format('Y-m-d');
    }
}
