<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

use Exception;
use Sip\Psinder\SharedKernel\Domain\Identity\Identity;
use function sprintf;

abstract class AggregateRootNotFound extends Exception
{
    final public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }

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
