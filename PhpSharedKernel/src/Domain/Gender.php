<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

use Assert\Assertion;

final class Gender
{
    public const MALE   = 'm';
    public const FEMALE = 'f';
    public const OTHER  = 'o';

    private const ALL = [
        self::MALE,
        self::FEMALE,
        self::OTHER,
    ];

    private string $value;

    private function __construct(string $name)
    {
        Assertion::inArray($name, self::ALL, 'Unknown geneder "%s". Known genders: "%s"');

        $this->value = $name;
    }

    public static function male(): self
    {
        return new self(self::MALE);
    }

    public static function female(): self
    {
        return new self(self::FEMALE);
    }

    public static function other(): self
    {
        return new self(self::OTHER);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(Gender $otherGender): bool
    {
        return $this->value === $otherGender->value;
    }
}
