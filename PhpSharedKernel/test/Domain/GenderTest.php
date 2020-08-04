<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test\Domain;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\SharedKernel\Domain\Gender;

class GenderTest extends TestCase
{
    private const EQUAL     = true;
    private const NOT_EQUAL = false;

    /**
     * @dataProvider comparsionExamplesProvider
     */
    public function testComparesWithOtherGenders(Gender $gender, Gender $otherGender, bool $expectedResult): void
    {
        self::assertSame($expectedResult, $gender->equals($otherGender));
    }

    /**
     * @return mixed[]
     */
    public function comparsionExamplesProvider(): iterable
    {
        $sameGender = Gender::male();

        yield 'same' => [
            $sameGender,
            $sameGender,
            self::EQUAL,
        ];

        yield 'equal' => [
            Gender::male(),
            Gender::male(),
            self::EQUAL,
        ];

        yield 'not equal' => [
            Gender::male(),
            Gender::female(),
            self::NOT_EQUAL,
        ];
    }
}
