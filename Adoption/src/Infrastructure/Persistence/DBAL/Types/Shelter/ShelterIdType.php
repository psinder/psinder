<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Shelter;

use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\UUIDType;

final class ShelterIdType extends UUIDType
{
    public function identityClass() : string
    {
        return ShelterId::class;
    }

    public static function name() : string
    {
        return 'ShelterId';
    }
}
