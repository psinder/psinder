<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain\Identity;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use function sprintf;

abstract class UUIDIdentity implements Identity
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        Assertion::true(Uuid::isValid($id), sprintf('Invalid UUID %s', $id));

        $this->id = $id;
    }

    public function toScalar() : string
    {
        return $this->id;
    }

    public function equals(Identity $otherIdentity) : bool
    {
        return $otherIdentity instanceof static
            && $this->id === $otherIdentity->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
