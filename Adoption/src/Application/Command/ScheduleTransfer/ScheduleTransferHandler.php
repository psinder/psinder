<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\ScheduleTransfer;

use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Transfer\TransferId;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;

use function assert;

final class ScheduleTransferHandler implements CommandHandler
{
    private Offers $offers;

    private Transfers $transfers;

    public function __construct(Offers $offers, Transfers $transfers)
    {
        $this->offers    = $offers;
        $this->transfers = $transfers;
    }

    public function __invoke(Command $command): void
    {
        assert($command instanceof ScheduleTransfer);

        $transferId = new TransferId($command->transferId());
        $offerId    = new OfferId($command->offerId());

        $offer = $this->offers->get($offerId);

        $transfer = $offer->prepareTransfer($transferId);

        $this->transfers->create($transfer);
    }
}
