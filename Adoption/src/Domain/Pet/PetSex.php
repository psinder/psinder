<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Pet;

use Assert\Assertion;

final class PetSex
{
    public const MALE   = 'm';
    public const FEMALE = 'f';

    private const ALL = [
        self::MALE,
        self::FEMALE,
    ];

    /** @var string */
    private $sex;

    private function __construct(string $sex)
    {
        Assertion::inArray($sex, self::ALL);

        $this->sex = $sex;
    }

    public static function fromString(string $sex) : self
    {
        return new self($sex);
    }

    public static function male() : self
    {
        return new self(self::MALE);
    }

    public static function female() : self
    {
        return new self(self::FEMALE);
    }

    public function toString() : string
    {
        return $this->sex;
    }
}
