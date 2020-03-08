<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter\SelectApplication;

use Sip\Psinder\SharedKernel\Application\Command\Command;

final class SelectApplication implements Command
{
    private string $offerId;

    private string $adopterId;

    public function __construct(string $offerId, string $adopterId)
    {
        $this->offerId   = $offerId;
        $this->adopterId = $adopterId;
    }

    public function offerId() : string
    {
        return $this->offerId;
    }

    public function adopterId() : string
    {
        return $this->adopterId;
    }
}
