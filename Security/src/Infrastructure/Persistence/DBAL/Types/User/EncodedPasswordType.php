<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Persistence\DBAL\Types\User;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Sip\Psinder\Security\Domain\User\HashedPassword;

use function is_string;

final class EncodedPasswordType extends StringType
{
    public static function name(): string
    {
        return 'EncodedPassword';
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof HashedPassword) {
            $value = $value->toString();
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
        if (is_string($value)) {
            return new HashedPassword($value);
        }

        return $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
