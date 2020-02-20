<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Shelter;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOffer;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOfferHandler;
use Sip\Psinder\Adoption\Domain\Offer\OfferPosted;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryOffers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryShelters;
use Sip\Psinder\Adoption\Test\Application\Command\PetFactoryFactory;
use Sip\Psinder\Adoption\Test\Application\Command\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryOffersFactory;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemorySheltersFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingTest;

final class PostOfferHandlerTest extends TestCase
{
    use EventsInterceptingTest;

    /** @var PostOfferHandler */
    private $handler;

    /** @var InMemoryShelters */
    private $shelters;

    /** @var InMemoryOffers */
    private $offers;

    public function setUp() : void
    {
        $this->shelters = InMemorySheltersFactory::create($this->eventPublisher());
        $this->offers   = InMemoryOffersFactory::create($this->eventPublisher());
        $this->handler  = new PostOfferHandler(
            $this->shelters,
            $this->offers,
            PetFactoryFactory::create()
        );
    }

    public function testCreatesNewOffer() : void
    {
        $id      = Uuid::uuid4()->toString();
        $shelter = ShelterMother::registeredWithRandomId();
        $pet     = PetMother::example();

        $this->shelters->create($shelter);

        $this->eventPublisher()->clear();

        $command = new PostOffer(
            $id,
            $shelter->id()->toScalar(),
            $pet
        );

        ($this->handler)($command);

        $this->assertPublishedEvents(
            new OfferPosted(
                $id,
                $shelter->id()->toScalar(),
                $pet->toArray(),
                new DateTimeImmutable()
            )
        );
    }

    public function testCreatesOfferForNotExistentShelter() : void
    {
        $id        = Uuid::uuid4()->toString();
        $shelterId = Uuid::uuid4()->toString();
        $pet       = PetMother::example();

        $command = new PostOffer(
            $id,
            $shelterId,
            $pet
        );

        $this->expectException(InvalidArgumentException::class);

        ($this->handler)($command);
    }

    protected function context() : TestCase
    {
        return $this;
    }
}
