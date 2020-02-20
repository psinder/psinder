<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Sip\Psinder\SharedKernel\Domain\Identity\Identity;

abstract class UUIDType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
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

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Identity) {
            return $value->toScalar();
        }

        if (is_string($value)) {
            return $value;
        }

        throw ConversionException::conversionFailed($value, static::name());
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return static::name();
    }

    abstract public function identityClass(): string;
    abstract public static function name(): string;
}
