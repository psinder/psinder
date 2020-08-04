<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test\Domain\Identity;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\SharedKernel\Domain\Identity\UUIDIdentity;

class UUIDIdentityTest extends TestCase
{
    private const EQUAL     = true;
    private const NOT_EQUAL = false;

    /**
     * @dataProvider comparsionExamplesProvider
     */
    public function testComparesWithOtherIdentities(
        UUIDIdentity $identity,
        UUIDIdentity $otherIdentity,
        bool $expectedResult
    ): void {
        self::assertSame($expectedResult, $identity->equals($otherIdentity));
    }

    /**
     * @return mixed[]
     */
    public function comparsionExamplesProvider(): iterable
    {
        $same = new TestUUIDIdentity(Uuid::uuid4()->toString());

        yield 'same' => [
            $same,
            $same,
            self::EQUAL,
        ];

        $first = new TestUUIDIdentity(Uuid::uuid4()->toString());

        yield 'equal' => [
            $first,
            new TestUUIDIdentity($first->toScalar()),
            self::EQUAL,
        ];

        yield 'not equal' => [
            new TestUUIDIdentity(Uuid::uuid4()->toString()),
            new TestUUIDIdentity(Uuid::uuid4()->toString()),
            self::NOT_EQUAL,
        ];
    }
}
