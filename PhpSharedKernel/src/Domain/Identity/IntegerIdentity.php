<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain\Identity;

use Assert\Assertion;
use function sprintf;

abstract class IntegerIdentity implements Identity
{
    private int $id;

    public function __construct(int $id)
    {
        Assertion::min(
            $id,
            1,
            sprintf('Tożsamość %d nie może być mniejsza od 1. Otrzymano: %s', static::class, $id)
        );

        $this->id = $id;
    }

    public function toScalar() : int
    {
        return $this->id;
    }

    public function equals(Identity $otherIdentity) : bool
    {
        return $otherIdentity instanceof self
            && $this->id === $otherIdentity->id;
    }

    public function __toString() : string
    {
        return (string) $this->id;
    }
}
