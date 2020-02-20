<?php
declare(strict_types = 1);

namespace Sip\Psinder\Adoption\Test\UI\Http\Shelter;

use DoctrineFixtures\ShelterFixture;
use Fig\Http\Message\RequestMethodInterface;
use PHPStan\Type\Php\IsStringFunctionTypeSpecifyingExtension;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\IsType;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Test\Application\Command\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\Adoption\Test\FunctionalTestCase;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class PostOfferRequestHandlerTest extends FunctionalTestCase
{
    public function testPostsValidOffer(): void
    {
        $request = $this->get(RequestBuilderFactory::class)
            ->createServerRequestBuilder()
            ->post()
            ->url('/offers')
            ->jsonBodyArray([
                'shelterId' => ShelterMother::exampleId()->toScalar(),
                'pet' => PetMother::example()->toArray()
            ])->create();

        $response = $this->handle($request);

        $this->assertResponseIsSuccess($response);
        $this->assertMessageBodyMatchesJson($response, [
            '$.id' => new IsType(IsType::TYPE_STRING)
        ]);
    }
}
