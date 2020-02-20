<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Types\DateType;
use Sip\Psinder\SharedKernel\Domain\Birthdate;

final class BirthdateType extends DateImmutableType implements DBALType
{
    public static function name() : string
    {
        return 'Birthdate';
    }

    public function getName()
    {
        return static::name();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Birthdate) {
            $value = \DateTimeImmutable::createFromFormat('Y-m-d', $value->toString());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $birthdateScalar = parent::convertToPHPValue($value, $platform);

        if (is_string($birthdateScalar)) {
            return Birthdate::fromString($birthdateScalar);
        }

        return $birthdateScalar;
    }
}
