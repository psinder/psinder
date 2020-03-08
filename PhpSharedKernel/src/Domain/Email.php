<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

use Assert\Assertion;

final class Email
{
    private string $address;

    public function __construct(string $address)
    {
        Assertion::email($address);

        $this->address = $address;
    }

    public static function fromString(string $address) : self
    {
        return new self($address);
    }

    public function toString() : string
    {
        return $this->address;
    }

    public function equals(Email $otherEmail) : bool
    {
        return $this->address === $otherEmail->address;
    }
}
