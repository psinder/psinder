<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\UI\Http\Shelter;

use Faker\Factory;
use PHPUnit\Framework\Constraint\IsType;
use Sip\Psinder\Adoption\Test\FunctionalTestCase;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class PostRegisterShelterRequestHandlerTest extends FunctionalTestCase
{
    public function testPostsValidOffer() : void
    {
        $faker   = Factory::create();
        $request = $this->get(RequestBuilderFactory::class)
            ->createServerRequestBuilder()
            ->post()
            ->url('/shelters')
            ->jsonSerializableBody([
                'email' => $faker->email,
                'password' => $faker->password,
                'name' => $faker->name,
                'addressStreet' => $faker->streetName,
                'addressNumber' => $faker->buildingNumber,
                'addressPostalCode' => $faker->postcode,
                'addressCity' => $faker->city,
            ])->create();

        $response = $this->handle($request);

        self::assertResponseIsSuccess($response);
        self::assertMessageBodyMatchesJson($response, [
            '$.id' => new IsType(IsType::TYPE_STRING),
        ]);
    }
}
