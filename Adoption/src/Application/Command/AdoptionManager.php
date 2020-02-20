<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Adopter\GivePet\GivePet;
use Sip\Psinder\Adoption\Application\Command\ScheduleTransfer\ScheduleTransfer;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSelected;
use Sip\Psinder\Adoption\Domain\Transfer\TransferCompleted;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;

final class AdoptionManager
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function scheduleTransferOnApplicationSelected(ApplicationSelected $event) : void
    {
        $transferId = Uuid::uuid4()->toString();

        $this->commandBus->dispatch(new ScheduleTransfer(
            $transferId,
            $event->offerId()
        ));
    }

    public function givePetToAdopterOnTransferCompleted(TransferCompleted $event) : void
    {
        $this->commandBus->dispatch(new GivePet(
            $event->adopterId(),
            new Pet(
                $event->pet()['id'],
                $event->pet()['name'],
                $event->pet()['sex'],
                $event->pet()['birthdate'],
                $event->pet()['type'],
                $event->pet()['breed']
            )
        ));
    }
}
