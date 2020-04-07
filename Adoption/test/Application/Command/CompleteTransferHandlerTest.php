<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\CompleteTransfer\CompleteTransfer;
use Sip\Psinder\Adoption\Domain\Transfer\TransferCompleted;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransferMother;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class CompleteTransferHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    /** @var CommandBus */
    private $bus;

    /** @var Transfers */
    private $transfers;

    public function setUp() : void
    {
        parent::setUp();
        $this->transfers = $this->get(Transfers::class);
        $this->bus       = $this->get(CommandBus::class);
    }

    public function testCompletesTransfer() : void
    {
        // Given
        $transfer = TransferMother::example();
        $this->transfers->create($transfer);
        $this->eventPublisher()->clear();

        $transferId = $transfer->id();

        // When
        $command = new CompleteTransfer($transferId->toScalar());
        $this->bus->dispatch($command);

        // Then
        $this->assertPublishedEvents(
            new TransferCompleted(
                $transferId->toScalar(),
                $transfer->adopterId()->toScalar(),
                $transfer->pet()->toPayload(),
                new DateTimeImmutable()
            )
        );
    }

    protected function context() : TestCase
    {
        return $this;
    }
}
