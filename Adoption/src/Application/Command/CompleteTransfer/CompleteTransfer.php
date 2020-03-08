<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\CompleteTransfer;

use Sip\Psinder\SharedKernel\Application\Command\Command;

final class CompleteTransfer implements Command
{
    private string $transferId;

    public function __construct(string $transferId)
    {
        $this->transferId = $transferId;
    }

    public function transferId() : string
    {
        return $this->transferId;
    }
}
