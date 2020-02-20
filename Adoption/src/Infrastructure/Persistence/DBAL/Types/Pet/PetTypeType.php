<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet;

use Sip\Psinder\Adoption\Domain\Pet\PetType;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\FromStringableVOType;
use function assert;

final class PetTypeType extends FromStringableVOType
{
    protected function voClass() : string
    {
        return PetType::class;
    }

    public static function name() : string
    {
        return 'PetType';
    }

    /** @param mixed $value */
    protected function convertToString($value) : string
    {
        assert($value instanceof PetType);

        return $value->name();
    }
}
