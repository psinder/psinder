<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet;

use Sip\Psinder\Adoption\Domain\Pet\PetSex;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\FromStringableVOType;
use function assert;

final class PetSexType extends FromStringableVOType
{
    protected function voClass() : string
    {
        return PetSex::class;
    }

    public static function name() : string
    {
        return 'PetSex';
    }

    /** @param mixed $value */
    protected function convertToString($value) : string
    {
        assert($value instanceof PetSex);

        return $value->toString();
    }
}
