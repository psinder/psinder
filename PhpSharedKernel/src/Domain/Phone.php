<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

use function sprintf;

final class Phone
{
    /** @var string */
    private $prefix;
    /** @var string */
    private $number;

    public function __construct(string $prefix, string $number)
    {
        $this->prefix = $prefix;
        $this->number = $number;
    }

    public static function fromPrefixAndNumber(string $prefix, string $number) : self
    {
        return new self($prefix, $number);
    }

    public function toString() : string
    {
        return sprintf('+%s %s', $this->prefix, $this->number);
    }

    public function prefix() : string
    {
        return $this->prefix;
    }

    public function number() : string
    {
        return $this->number;
    }

    public function equals(Phone $otherPhone) : bool
    {
        return $this->prefix === $otherPhone->prefix
            && $this->number === $otherPhone->number;
    }
}
