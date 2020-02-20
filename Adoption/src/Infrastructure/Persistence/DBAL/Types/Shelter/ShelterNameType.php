<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Shelter;

use Sip\Psinder\Adoption\Domain\Shelter\ShelterName;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\FromStringableVOType;
use function assert;

final class ShelterNameType extends FromStringableVOType
{
    protected function voClass() : string
    {
        return ShelterName::class;
    }

    public static function name() : string
    {
        return 'ShelterName';
    }

    /** @param mixed $value */
    protected function convertToString($value) : string
    {
        assert($value instanceof ShelterName);

        return $value->toString();
    }
}
