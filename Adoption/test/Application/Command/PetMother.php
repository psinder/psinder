<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use Sip\Psinder\Adoption\Application\Command\Pet;
use Sip\Psinder\Adoption\Domain\Pet\PetSex;

final class PetMother
{
    private const EXAMPLE_ID = '035be0ba-b295-4b99-ab5a-e9472420e2d1';

    public static function example(): Pet
    {
        return new Pet(
            self::EXAMPLE_ID,
            'Foo',
            PetSex::MALE,
            '2015-01-01',
            'Dog',
            'Labrador'
        );
    }
}
