<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Shelter;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterName;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Test\Domain\AddressMother;

final class ShelterMother
{
    private const EXAMPLE_ID = 'baec7e53-bbc9-4537-9541-d6a8df844c6a';

    public static function randomId() : ShelterId
    {
        return new ShelterId(Uuid::uuid4()->toString());
    }

    public static function exampleId() : ShelterId
    {
        return new ShelterId(self::EXAMPLE_ID);
    }

    public static function registeredWithRandomId() : Shelter
    {
        return Shelter::register(
            self::randomId(),
            ShelterName::fromString('Foo'),
            AddressMother::example(),
            Email::fromString('foo@example.com')
        );
    }
}
