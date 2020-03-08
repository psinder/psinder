<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Query;

use Sip\Psinder\Adoption\Application\Query\Shelter\GetOfferDetails\GetOfferDetails;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferBuilder;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;

class GetOfferDetailsTest extends TransactionalTestCase
{
    /** @var QueryBus */
    private $bus;

    /** @var Offers */
    private $offers;

    public function setUp() : void
    {
        parent::setUp();

        $this->bus    = $this->get(QueryBus::class);
        $this->offers = $this->get(Offers::class);
    }

    public function testFetchesDetailsForNonExistingOffer() : void
    {
        $result = $this->bus->execute(new GetOfferDetails(OfferMother::randomId()->toScalar()));

        self::assertNull($result);
    }

    public function testFetchesDetailsForExistingOffer() : void
    {
        $pet       = PetMother::example();
        $id        = OfferMother::randomId();
        $shelterId = ShelterMother::randomId();
        $offer     = (new OfferBuilder())
            ->id($id)
            ->shelter($shelterId)
            ->pet($pet)
            ->get();
        $this->offers->create($offer);

        $result = $this->bus->execute(new GetOfferDetails($id->toScalar()));

        self::assertEquals(
            [
                'id' => $id->toScalar(),
                'shelterId' => $shelterId->toScalar(),
                'pet' => $pet->toPayload(),
            ],
            $result->toArray()
        );
    }
}
