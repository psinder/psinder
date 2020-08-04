<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\UI\Http\Adopter;

use Faker\Factory;
use Sip\Psinder\Adoption\Test\FunctionalTestCase;
use Sip\Psinder\Adoption\UI\Http\Adopter\PostRegisterAdopterRequest;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AnonymousUser;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class PostRegisterAdopterRequestTest extends FunctionalTestCase
{
    public function testRegistersAdopter(): void
    {
        $this->impersonate(new AnonymousUser());

        $faker = Factory::create();

        $request = $this->get(RequestBuilderFactory::class)
            ->createServerRequestBuilder()
            ->post()
            ->jsonSerializableBody(new PostRegisterAdopterRequest(
                $faker->email,
                $faker->password,
                $faker->firstName,
                $faker->lastName,
                $faker->date('Y-m-d', '-15 years'),
                'o'
            ))
            ->url('/adopters')
            ->create();

        $response = $this->handle($request);

        self::assertResponseIsSuccess($response);

        // TODO: Verify I can log in
    }
}
