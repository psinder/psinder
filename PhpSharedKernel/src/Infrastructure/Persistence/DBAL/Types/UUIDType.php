<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Sip\Psinder\SharedKernel\Domain\Identity\Identity;
use function is_string;

abstract class UUIDType extends Type
{
    /**
     * @param mixed[] $fieldDeclaration
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $class = $this->identityClass();

        if ($value instanceof $class) {
            return $value;
        }

        try {
            return new $class($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::name());
        }
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Identity) {
            return $value->toScalar();
        }

        if (is_string($value)) {
            return $value;
        }

        throw ConversionException::conversionFailedInvalidType($value, 'string', [Identity::class, 'string']);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    public function getName() : string
    {
        return static::name();
    }

    abstract public function identityClass() : string;
    abstract public static function name() : string;
}
