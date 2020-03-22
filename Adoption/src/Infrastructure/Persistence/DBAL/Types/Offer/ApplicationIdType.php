<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Offer;

use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationId;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\UUIDType;

final class ApplicationIdType extends UUIDType
{
    public function identityClass() : string
    {
        return ApplicationId::class;
    }

    public static function name() : string
    {
        return 'ApplicationId';
    }
}
