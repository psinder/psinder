<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\UI\Http\Shelter;

use PHPUnit\Framework\Constraint\IsType;
use Sip\Psinder\Adoption\Test\Application\Command\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\Adoption\Test\FunctionalTestCase;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\LoggedInUser;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class PostOfferRequestHandlerTest extends FunctionalTestCase
{
    public function testPostsValidOffer(): void
    {
        $shelterId = ShelterMother::exampleId()->toScalar();
        $request   = $this->get(RequestBuilderFactory::class)
            ->createServerRequestBuilder()
            ->post()
            ->url('/offers')
            ->jsonSerializableBody([
                'shelterId' => $shelterId,
                'pet' => PetMother::example()->toArray(),
            ])->create();

        $this->impersonate(new LoggedInUser(
            $shelterId,
            ['shelter']
        ));

        $response = $this->handle($request);

        self::assertResponseIsSuccess($response);
        self::assertMessageBodyMatchesJson($response, [
            '$.id' => new IsType(IsType::TYPE_STRING),
        ]);
    }
}
