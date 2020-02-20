<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Shelter;

final class ShelterName
{
    /** @var string */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name) : self
    {
        return new self($name);
    }

    public function toString() : string
    {
        return $this->name;
    }
}
