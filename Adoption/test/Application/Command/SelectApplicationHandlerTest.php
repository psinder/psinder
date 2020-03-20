<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\Shelter\SelectApplication\SelectApplication;
use Sip\Psinder\Adoption\Application\Command\Shelter\SelectApplication\SelectApplicationHandler;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSelected;
use Sip\Psinder\Adoption\Domain\Offer\OfferClosed;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryOffers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Application\ApplicationMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryOffersFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class SelectApplicationHandlerTest extends TestCase
{
    use EventsInterceptingIsolatedTest;

    /** @var SelectApplicationHandler */
    private $handler;

    /** @var InMemoryOffers */
    private $offers;

    public function setUp() : void
    {
        $this->offers  = InMemoryOffersFactory::create($this->eventPublisher());
        $this->handler = new SelectApplicationHandler($this->offers);
    }

    public function testSelectsApplication() : void
    {
        $adopterId   = AdopterMother::exampleId();
        $offer       = OfferMother::example();
        $application = ApplicationMother::withAdopter($adopterId);

        $offer->apply($application);

        $this->offers->create($offer);

        $this->eventPublisher()->clear();

        $command = new SelectApplication(
            $offer->id()->toScalar(),
            $adopterId->toScalar()
        );

        ($this->handler)($command);

        $this->assertPublishedEvents(
            ApplicationSelected::occur($adopterId, $offer->id()),
            OfferClosed::occur($offer->id())
        );
    }

    protected function context() : TestCase
    {
        return $this;
    }
}
