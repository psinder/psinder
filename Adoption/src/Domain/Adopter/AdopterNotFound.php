<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Adopter;

use Exception;

use function sprintf;

final class AdopterNotFound extends Exception
{
    public static function forId(AdopterId $id): self
    {
        return new self(sprintf(
            'Adopter with id %s not found',
            $id->toScalar()
        ));
    }
}
