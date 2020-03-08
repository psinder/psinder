<?php
declare(strict_types = 1);

namespace Sip\Psinder\Adoption\Test\UI\Http\Adopter;

use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Test\FunctionalTestCase;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\LoggedInUser;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class PostApplicationRequestHandlerTest extends FunctionalTestCase
{
    public function testAppliesForOffer() : void
    {
        $offerId = OfferMother::randomId();
        $shelterId = ShelterMother::exampleId();
        $adopterId = AdopterMother::exampleId();
        /** @var Offers $offers */
        $offers = $this->get(Offers::class);

        $offers->create(Offer::post(
            $offerId,
            $shelterId,
            PetMother::example()
        ));

        $this->impersonate(new LoggedInUser(
            $adopterId->toScalar(),
            ['adopter']
        ));

        $request   = $this->get(RequestBuilderFactory::class)
            ->createServerRequestBuilder()
            ->post()
            ->url(\Safe\sprintf('/offers/%s/apply', $offerId->toScalar()))
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
