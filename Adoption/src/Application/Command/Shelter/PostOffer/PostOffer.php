<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer;

use Sip\Psinder\Adoption\Application\Command\Pet;
use Sip\Psinder\SharedKernel\Application\Command\Command;

final class PostOffer implements Command
{
    private string $shelterId;

    private Pet $pet;

    private string $offerId;

    public function __construct(string $offerId, string $shelterId, Pet $pet)
    {
        $this->offerId   = $offerId;
        $this->shelterId = $shelterId;
        $this->pet       = $pet;
    }

    public function offerId() : string
    {
        return $this->offerId;
    }

    public function shelterId() : string
    {
        return $this->shelterId;
    }

    public function pet() : Pet
    {
        return $this->pet;
    }
}
