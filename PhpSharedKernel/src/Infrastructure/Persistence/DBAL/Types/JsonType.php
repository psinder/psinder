<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class JsonType extends \Doctrine\DBAL\Types\JsonType implements DBALType
{
    public function getName()
    {
        return static::name();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
