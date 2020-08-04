<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter;

use Sip\Psinder\Adoption\Domain\Adopter\Adopter;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterName;
use Sip\Psinder\SharedKernel\Domain\Birthdate;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Gender;

final class AdopterFactory
{
    public function create(
        string $id,
        string $firstName,
        string $lastName,
        string $birthdate,
        string $gender,
        string $email
    ): Adopter {
        return Adopter::register(
            new AdopterId($id),
            AdopterName::fromFirstAndLastName($firstName, $lastName),
            Birthdate::fromString($birthdate),
            Gender::fromString($gender),
            Email::fromString($email)
        );
    }
}
