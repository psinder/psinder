<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Adopter;

use function sprintf;

final class AdopterName
{
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;

    private function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
    }

    public static function fromFirstAndLastName(string $firstName, string $lastName) : self
    {
        return new self($firstName, $lastName);
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function lastName() : string
    {
        return $this->lastName;
    }

    public function fullName() : string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }
}
