<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test\Domain;

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\SharedKernel\Domain\Birthdate;

class BirthdateTest extends TestCase
{
    private const FORMAT = 'Y-m-d';

    /**
     * @dataProvider ageExamples
     */
    public function testCalculatesAge(string $date, int $expectedAge) : void
    {
        $birthDate = Birthdate::fromString($date);

        self::assertSame($expectedAge, $birthDate->age());
    }

    /**
     * @return mixed[]
     */
    public function ageExamples() : iterable
    {
        yield 'on birthdate' => [
            (new DateTimeImmutable())
                ->sub(new DateInterval('P10Y'))
                ->format(self::FORMAT),
            10,
        ];

        yield 'day before birthdate' => [
            (new DateTimeImmutable())
                ->sub(new DateInterval('P10Y'))
                ->add(new DateInterval('P1D'))
                ->format(self::FORMAT),
            9,
        ];
    }
}
