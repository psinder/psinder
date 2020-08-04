<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\Shelter\SelectApplication\SelectApplication;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSelected;
use Sip\Psinder\Adoption\Domain\Offer\OfferClosed;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class SelectApplicationHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private Offers $offers;
    private CommandBus $bus;

    public function setUp(): void
    {
        parent::setUp();

        $this->offers = $this->get(Offers::class);
        $this->bus    = $this->get(CommandBus::class);
    }

    public function testSelectsApplication(): void
    {
        $adopterId = AdopterMother::exampleId();
        $offer     = OfferMother::example();

        $offer->apply($adopterId);

        $this->offers->create($offer);

        $this->eventPublisher()->clear();

        $command = new SelectApplication(
            $offer->id()->toScalar(),
            $adopterId->toScalar()
        );

        $this->bus->dispatch($command);

        $this->assertPublishedEvents(
            ApplicationSelected::occur($adopterId, $offer->id()),
            OfferClosed::occur($offer->id())
        );
    }

    protected function context(): TestCase
    {
        return $this;
    }
}
