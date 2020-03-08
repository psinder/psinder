<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\GivePet;

use Sip\Psinder\Adoption\Application\Command\Pet;
use Sip\Psinder\SharedKernel\Application\Command\Command;

final class GivePet implements Command
{
    private string $adopterId;

    private Pet $pet;

    public function __construct(string $adopterId, Pet $pet)
    {
        $this->adopterId = $adopterId;
        $this->pet       = $pet;
    }

    public function adopterId() : string
    {
        return $this->adopterId;
    }

    public function pet() : Pet
    {
        return $this->pet;
    }
}
