<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test\Domain\Identity;

use Sip\Psinder\SharedKernel\Domain\Identity\Identities;
use Sip\Psinder\SharedKernel\Domain\Identity\IntegerIdentity;

final class TestIntegerIdentities extends Identities
{
    public function storedIdentityClass() : string
    {
        return IntegerIdentity::class;
    }
}
