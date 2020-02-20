<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test\Domain\Identity;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\SharedKernel\Domain\Identity\IntegerIdentity;

class IntegerIdentityTest extends TestCase
{
    private const EQUAL     = true;
    private const NOT_EQUAL = false;

    /**
     * @dataProvider comparsionExamplesProvider
     */
    public function testComparesWithOtherIdentities(
        IntegerIdentity $identity,
        IntegerIdentity $otherIdentity,
        bool $expectedResult
    ) : void {
        self::assertSame($expectedResult, $identity->equals($otherIdentity));
    }

    /**
     * @return mixed[]
     */
    public function comparsionExamplesProvider() : iterable
    {
        $same = new TestIntegerIdentity(1);

        yield 'same' => [
            $same,
            $same,
            self::EQUAL,
        ];

        yield 'equal' => [
            new TestIntegerIdentity(1),
            new TestIntegerIdentity(1),
            self::EQUAL,
        ];

        yield 'not equal' => [
            new TestIntegerIdentity(1),
            new TestIntegerIdentity(2),
            self::NOT_EQUAL,
        ];
    }
}
