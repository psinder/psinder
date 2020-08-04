<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet;

use Sip\Psinder\Adoption\Domain\Pet\PetName;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\FromStringableVOType;

use function assert;

final class PetNameType extends FromStringableVOType
{
    protected function voClass(): string
    {
        return PetName::class;
    }

    public static function name(): string
    {
        return 'PetName';
    }

    /** @param mixed $value */
    protected function convertToString($value): string
    {
        assert($value instanceof PetName);

        return $value->toString();
    }
}
