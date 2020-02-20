<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Pet;

final class PetBreed
{
    /** @var PetType */
    private $type;
    /** @var string */
    private $name;

    private function __construct(PetType $type, string $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    public static function fromTypeAndName(PetType $type, string $name) : self
    {
        return new self($type, $name);
    }

    public function type() : PetType
    {
        return $this->type;
    }

    public function name() : string
    {
        return $this->name;
    }
}
