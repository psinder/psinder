<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

use Exception;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;

use function sprintf;

final class AlreadyApplied extends Exception implements CannotApply
{
    public static function forAdopterAndOffer(AdopterId $adopterId, OfferId $offerId): self
    {
        return new self(sprintf(
            'Adopter %s already applied for an offer %s',
            $adopterId->toScalar(),
            $offerId->toScalar()
        ));
    }
}
