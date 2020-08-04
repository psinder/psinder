<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption;

use Sip\Psinder\SharedKernel\Application\Command\Command;

final class ApplyForAdoption implements Command
{
    private string $adopterId;

    private string $offerId;

    public function __construct(string $adopterId, string $offerId)
    {
        $this->adopterId = $adopterId;
        $this->offerId   = $offerId;
    }

    public function adopterId(): string
    {
        return $this->adopterId;
    }

    public function offerId(): string
    {
        return $this->offerId;
    }
}
