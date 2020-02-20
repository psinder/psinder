<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Persistence\DBAL\Types\User;

use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\UUIDType;

final class UserIdType extends UUIDType
{
    public function identityClass() : string
    {
        return UserId::class;
    }

    public static function name() : string
    {
        return 'UserId';
    }
}
