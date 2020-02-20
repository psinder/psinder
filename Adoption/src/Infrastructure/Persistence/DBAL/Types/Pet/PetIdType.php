<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet;

use Sip\Psinder\Adoption\Domain\Pet\PetId;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\UUIDType;

final class PetIdType extends UUIDType
{
    public function identityClass() : string
    {
        return PetId::class;
    }

    public static function name() : string
    {
        return 'PetId';
    }
}
