<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\CompleteTransfer\CompleteTransfer;
use Sip\Psinder\Adoption\Application\Command\CompleteTransfer\CompleteTransferHandler;
use Sip\Psinder\Adoption\Domain\Transfer\TransferCompleted;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryTransfers;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransferMother;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryTransfersFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingTest;

final class CompleteTransferHandlerTest extends TestCase
{
    use EventsInterceptingTest;

    /** @var CompleteTransferHandler */
    private $handler;

    /** @var InMemoryTransfers */
    private $transfers;

    public function setUp() : void
    {
        $this->transfers = InMemoryTransfersFactory::create($this->eventPublisher());
        $this->handler   = new CompleteTransferHandler($this->transfers);
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
        ($this->handler)($command);

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
