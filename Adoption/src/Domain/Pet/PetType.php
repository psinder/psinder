<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Pet;

final class PetType
{
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name) : self
    {
        return new self($name);
    }

    public function name() : string
    {
        return $this->name;
    }
}
