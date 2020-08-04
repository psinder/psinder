<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Offer;

use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\UUIDType;

final class OfferIdType extends UUIDType
{
    public function identityClass(): string
    {
        return OfferId::class;
    }

    public static function name(): string
    {
        return 'OfferId';
    }
}
