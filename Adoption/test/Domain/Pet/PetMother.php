<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Pet;

use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\Adoption\Domain\Pet\PetBreed;
use Sip\Psinder\Adoption\Domain\Pet\PetId;
use Sip\Psinder\Adoption\Domain\Pet\PetName;
use Sip\Psinder\Adoption\Domain\Pet\PetSex;
use Sip\Psinder\Adoption\Domain\Pet\PetType;
use Sip\Psinder\SharedKernel\Domain\Birthdate;

final class PetMother
{
    private const EXAMPLE_ID = '6144a4bc-6032-4c96-9407-b2d958c86849';

    public static function exampleId(): PetId
    {
        return new PetId(self::EXAMPLE_ID);
    }

    public static function example(): Pet
    {
        return Pet::register(
            self::exampleId(),
            PetName::fromString('Woof'),
            PetSex::male(),
            Birthdate::fromString('2015-01-01'),
            PetBreed::fromTypeAndName(
                PetType::fromString('Dog'),
                'Labrador'
            )
        );
    }

    public static function random(): Pet
    {
        $faker = Factory::create();

        return Pet::register(
            new PetId(Uuid::uuid4()->toString()),
            PetName::fromString($faker->word),
            PetSex::male(),
            Birthdate::fromString($faker->date('Y-m-d', '-2 years')),
            PetBreed::fromTypeAndName(
                PetType::fromString('Dog'),
                $faker->word
            )
        );
    }
}
