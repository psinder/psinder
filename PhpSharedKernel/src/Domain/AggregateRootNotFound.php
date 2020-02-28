<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

use Sip\Psinder\SharedKernel\Domain\Identity\Identity;

abstract class AggregateRootNotFound extends \Exception
{
    public static function forId(Identity $id) : self
    {
        return new static(sprintf(
            '%s with id %s not found',
            static::name(),
            $id->toScalar()
        ));
    }

    abstract public static function name() : string;
}
