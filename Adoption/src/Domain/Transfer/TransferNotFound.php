<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Transfer;

use Exception;

use function sprintf;

final class TransferNotFound extends Exception
{
    public static function forId(TransferId $id): self
    {
        return new self(sprintf(
            'Transfer with id %s not found',
            $id->toScalar()
        ));
    }
}
