<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Adopter;

use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\UUIDType;

final class AdopterIdType extends UUIDType
{
    public function identityClass() : string
    {
        return AdopterId::class;
    }

    public static function name() : string
    {
        return 'AdopterId';
    }
}
