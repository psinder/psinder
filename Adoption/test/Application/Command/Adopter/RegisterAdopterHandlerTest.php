<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Adopter;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopter;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopterHandler;
use Sip\Psinder\Adoption\Application\Command\UserRegisterer;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterRegistered;
use Sip\Psinder\Adoption\Test\Application\UserRegistererStub;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Domain\Gender;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class RegisterAdopterHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private RegisterAdopterHandler $handler;

    public function setUp(): void
    {
        $this->overrideServiceAliasWithInstance(UserRegisterer::class, new UserRegistererStub());
        parent::setUp();
        $this->handler = $this->get(RegisterAdopterHandler::class);
    }

    public function testRegistersValidShelter(): void
    {
        $id        = Uuid::uuid4()->toString();
        $firstName = 'Foo';
        $lastName  = 'Bar';
        $email     = 'foo@example.com';
        $birthdate = '1990-01-01';
        $gender    = Gender::OTHER;

        $command = new RegisterAdopter(
            $id,
            $firstName,
            $lastName,
            $email,
            'foobar',
            $birthdate,
            $gender
        );

        ($this->handler)($command);

        $this->assertPublishedEvent(new AdopterRegistered(
            $id,
            $firstName,
            $lastName,
            $email,
            $birthdate,
            $gender,
            new DateTimeImmutable()
        ));
    }

    protected function context(): TestCase
    {
        return $this;
    }
}
