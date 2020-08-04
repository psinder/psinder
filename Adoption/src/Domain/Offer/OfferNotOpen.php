<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

use Exception;

use function sprintf;

final class OfferNotOpen extends Exception implements CannotApply
{
    public static function forId(OfferId $id): self
    {
        return new self(sprintf(
            'Offer %s is not open for applications',
            $id->toScalar()
        ));
    }
}
