<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Transfer;

use Sip\Psinder\Adoption\Domain\Transfer\TransferId;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\UUIDType;

final class TransferIdType extends UUIDType
{
    public function identityClass() : string
    {
        return TransferId::class;
    }

    public static function name() : string
    {
        return 'TransferId';
    }
}
