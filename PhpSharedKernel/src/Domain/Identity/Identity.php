<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain\Identity;

interface Identity
{
    /**
     * @return int|string|float
     */
    public function toScalar();

    public function equals(Identity $otherIdentity) : bool;

    public function __toString() : string;
}
