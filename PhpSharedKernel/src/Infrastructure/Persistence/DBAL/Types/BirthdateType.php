<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types;

use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateImmutableType;
use Sip\Psinder\SharedKernel\Domain\Birthdate;
use function is_string;

final class BirthdateType extends DateImmutableType implements DBALType
{
    public static function name() : string
    {
        return 'Birthdate';
    }

    public function getName() : string
    {
        return static::name();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Birthdate) {
            $value = DateTimeImmutable::createFromFormat('Y-m-d', $value->toString());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $birthdate = parent::convertToPHPValue($value, $platform);

        if (is_string($birthdate)) {
            return Birthdate::fromString($birthdate);
        }

        if ($birthdate instanceof DateTimeImmutable) {
            return Birthdate::fromDateTimeImmutable($birthdate);
        }

        return $birthdate;
    }
}
