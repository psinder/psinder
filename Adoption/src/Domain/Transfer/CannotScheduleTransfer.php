<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Transfer;

use Exception;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;

use function sprintf;

final class CannotScheduleTransfer extends Exception
{
    public static function applicationNotSelected(OfferId $offerId): self
    {
        return new self(sprintf(
            'Cannot schedule transfer for offer %s because application was not selected',
            $offerId->toScalar()
        ));
    }
}
