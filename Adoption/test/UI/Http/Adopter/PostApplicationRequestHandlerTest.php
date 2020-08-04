<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\UI\Http\Adopter;

use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\Adoption\Test\FunctionalTestCase;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\LoggedInUser;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

use function assert;
use function Safe\sprintf;

final class PostApplicationRequestHandlerTest extends FunctionalTestCase
{
    public function testAppliesForOffer(): void
    {
        $offerId   = OfferMother::randomId();
        $shelterId = ShelterMother::exampleId();
        $adopter   = AdopterMother::registeredExample();
        $adopterId = $adopter->id();
        $offers    = $this->get(Offers::class);
        assert($offers instanceof Offers);
        $adopters = $this->get(Adopters::class);
        assert($adopters instanceof Adopters);
        $adopters->create($adopter);

        $offers->create(Offer::post(
            $offerId,
            $shelterId,
            PetMother::random()
        ));

        $this->impersonate(new LoggedInUser(
            $adopterId->toScalar(),
            ['adopter']
        ));

        $request = $this->get(RequestBuilderFactory::class)
            ->createServerRequestBuilder()
            ->post()
            ->url(sprintf('/offers/%s/applications', $offerId->toScalar()))
            ->create();

        $this->impersonate(new LoggedInUser(
            $adopterId->toScalar(),
            ['adopter']
        ));

        $response = $this->handle($request);

        self::assertResponseIsSuccess($response);

        // TODO: Assert against read model when it's ready
    }
}
