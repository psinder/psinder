<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\CompleteTransfer;

use Sip\Psinder\Adoption\Domain\Transfer\TransferId;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use function assert;

final class CompleteTransferHandler implements CommandHandler
{
    /** @var Transfers */
    private $transfers;

    public function __construct(Transfers $transfers)
    {
        $this->transfers = $transfers;
    }

    public function __invoke(Command $command) : void
    {
        assert($command instanceof CompleteTransfer);

        $transferId = new TransferId($command->transferId());
        $transfer   = $this->transfers->get($transferId);

        $transfer->complete();

        $this->transfers->update($transfer);
    }
}
