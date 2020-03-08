<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\ScheduleTransfer;

use Sip\Psinder\SharedKernel\Application\Command\Command;

final class ScheduleTransfer implements Command
{
    private string $offerId;

    private string $transferId;

    public function __construct(string $transferId, string $offerId)
    {
        $this->offerId    = $offerId;
        $this->transferId = $transferId;
    }

    public function transferId() : string
    {
        return $this->transferId;
    }

    public function offerId() : string
    {
        return $this->offerId;
    }
}
