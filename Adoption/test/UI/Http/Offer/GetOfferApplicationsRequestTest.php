<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\UI\Http\Offer;

use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\Adoption\Test\FunctionalTestCase;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class GetOfferApplicationsRequestTest extends FunctionalTestCase
{
    private Offers $offers;
    private Adopters $adopters;
    private Shelters $shelters;

    public function setUp() : void
    {
        parent::setUp();

        $this->adopters = $this->get(Adopters::class);
        $this->shelters = $this->get(Shelters::class);
        $this->offers   = $this->get(Offers::class);
    }

    public function testGetsExistingOfferApplications() : void
    {
        $adopter = AdopterMother::registeredRandom();
        $this->adopters->create($adopter);
        $shelter = ShelterMother::registeredWithRandomId();
        $this->shelters->create($shelter);
        $offer = OfferMother::withShelter($shelter->id());
        $offer->apply($adopter->id());
        $this->offers->create($offer);

        $request = $this->get(RequestBuilderFactory::class)
            ->createServerRequestBuilder()
            ->url('/offers/' . $offer->id()->toScalar() . '/applications')
            ->create();

        $response = $this->handle($request);

        self::assertResponseIsSuccess($response);
        self::assertMessageBodyMatchesJson($response, [
            '$..offerId' => $offer->id()->toScalar(),
            '$..shelterId' => $shelter->id()->toScalar(),
            '$..adopterId' => $adopter->id()->toScalar(),
            '$..shelterName' => $shelter->name()->toString(),
            '$..adopterName' => $adopter->name()->fullName(),
        ]);
    }
}
