<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

use Exception;
use function sprintf;

final class OfferNotFound extends Exception
{
    public static function forId(OfferId $id) : self
    {
        return new self(sprintf(
            'Adoption offer with id %s not found',
            $id->toScalar()
        ));
    }
}
