<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Shelter;

use Exception;
use Sip\Psinder\Adoption\Domain\Pet\PetId;
use function sprintf;

final class ShelterNotFound extends Exception
{
    public static function forId(ShelterId $id) : self
    {
        return new self(sprintf(
            'Shelter with id %s not found',
            $id->toScalar()
        ));
    }

    public static function havingPet(PetId $petId) : self
    {
        return new self(sprintf(
            'Shelter having pet with id %s not found',
            $petId->toScalar()
        ));
    }
}
