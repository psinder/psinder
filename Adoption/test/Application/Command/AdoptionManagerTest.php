<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Adopter\GivePet\GivePet;
use Sip\Psinder\Adoption\Application\Command\AdoptionManager;
use Sip\Psinder\Adoption\Application\Command\ScheduleTransfer\ScheduleTransfer;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSelected;
use Sip\Psinder\Adoption\Domain\Transfer\TransferCompleted;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransferMother;
use Sip\Psinder\SharedKernel\Application\Command\InterceptingCommandBus;

final class AdoptionManagerTest extends TestCase
{
    /** @var InterceptingCommandBus */
    private $commandBus;

    /** @var AdoptionManager */
    private $manager;

    protected function setUp() : void
    {
        $this->commandBus = new InterceptingCommandBus();
        $this->manager    = new AdoptionManager($this->commandBus);
    }

    public function testScheduleTransferOnApplicationSelected() : void
    {
        $adopterId = AdopterMother::randomId();
        $offerId   = OfferMother::randomId();

        $event = ApplicationSelected::occur(
            $adopterId,
            $offerId
        );

        $this->manager->scheduleTransferOnApplicationSelected($event);

        self::assertCount(1, $this->commandBus);
        $last = $this->commandBus->last();
        self::assertInstanceOf(ScheduleTransfer::class, $last);
        /** @var ScheduleTransfer $last */
        self::assertSame($offerId->toScalar(), $last->offerId());
        self::assertTrue(Uuid::isValid($last->transferId()));
    }

    public function testGivePetToAdopterOnTransferCompleted() : void
    {
        $transfer   = TransferMother::example();
        $transferId = $transfer->id();
        $adopterId  = $transfer->adopterId();

        $event = TransferCompleted::occur(
            $transferId,
            $adopterId,
            $transfer->pet()
        );

        $this->manager->givePetToAdopterOnTransferCompleted($event);

        self::assertCount(1, $this->commandBus);
        $last = $this->commandBus->last();
        self::assertInstanceOf(GivePet::class, $last);
        /** @var GivePet $last */
        self::assertSame($adopterId->toScalar(), $last->adopterId());
        self::assertSame($transfer->pet()->toPayload(), $last->pet()->toArray());
    }
}
