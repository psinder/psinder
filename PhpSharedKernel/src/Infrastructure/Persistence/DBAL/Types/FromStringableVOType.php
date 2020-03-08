<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use function call_user_func;
use function method_exists;

abstract class FromStringableVOType extends StringType
{
    public function getName() : string
    {
        return static::name();
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

        $class = $this->voClass();

        if (method_exists($class, 'fromString')) {
            /** @var callable $callable */
            $callable = [$class, 'fromString'];

            return call_user_func($callable, $value);
        }

        throw ConversionException::conversionFailed($value, static::name());
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

        return $this->convertToString($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    abstract protected function voClass() : string;
    /** @param mixed $value */
    abstract protected function convertToString($value) : string;
    abstract public static function name() : string;
}
