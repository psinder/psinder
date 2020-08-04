<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Adopter;

use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Adopter\Adopter;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterName;
use Sip\Psinder\SharedKernel\Domain\Birthdate;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Gender;

final class AdopterMother
{
    private const EXAMPLE_ID = '5c5e43e7-a254-4653-bc51-19f03f2eb3ee';

    public static function randomId(): AdopterId
    {
        return new AdopterId(Uuid::uuid4()->toString());
    }

    public static function exampleId(): AdopterId
    {
        return new AdopterId(self::EXAMPLE_ID);
    }

    public static function registeredExample(): Adopter
    {
        return Adopter::register(
            self::exampleId(),
            AdopterName::fromFirstAndLastName('Foo', 'Bar'),
            Birthdate::fromString('1990-01-01'),
            Gender::other(),
            Email::fromString('foo.bar@example.com')
        );
    }

    public static function registeredRandom(): Adopter
    {
        $faker = Factory::create();

        return Adopter::register(
            self::randomId(),
            AdopterName::fromFirstAndLastName($faker->firstName, $faker->lastName),
            Birthdate::fromString($faker->date('Y-m-d', '-18 years')),
            Gender::other(),
            Email::fromString($faker->email)
        );
    }
}
