<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command;

use Sip\Psinder\Adoption\Application\Command\Pet as PetDTO;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\Adoption\Domain\Pet\PetBreed;
use Sip\Psinder\Adoption\Domain\Pet\PetId;
use Sip\Psinder\Adoption\Domain\Pet\PetName;
use Sip\Psinder\Adoption\Domain\Pet\PetSex;
use Sip\Psinder\Adoption\Domain\Pet\PetType;
use Sip\Psinder\SharedKernel\Domain\Birthdate;

final class PetFactory
{
    public function create(PetDTO $dto): Pet
    {
        return Pet::register(
            new PetId($dto->id()),
            PetName::fromString($dto->name()),
            PetSex::fromString($dto->sex()),
            Birthdate::fromString($dto->birthdate()),
            PetBreed::fromTypeAndName(
                PetType::fromString($dto->type()),
                $dto->breed()
            )
        );
    }
}
