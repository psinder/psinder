<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test\Domain\Identity;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\SharedKernel\Domain\Identity\Identity;

class IdentitiesTest extends TestCase
{
    public function testIgnoresDuplicates() : void
    {
        $identityArray = [
            new TestIntegerIdentity(1),
            new TestIntegerIdentity(1),
            new TestIntegerIdentity(2),
        ];

        $result = new TestIntegerIdentities($identityArray);

        self::assertCount(2, $result);
        self::assertSame([1, 2], $result->toScalarArray());
    }

    public function testAllowsSubtypes() : void
    {
        $identityArray = [new class implements Identity {
            public function toScalar() : int
            {
                return 1;
            }

            public function equals(Identity $otherIdentity) : bool
            {
                return true;
            }

            public function __toString()
            {
                return '1';
            }
        },
        ];

        $result = new TestIdentities($identityArray);

        self::assertCount(1, $result);
    }
}
