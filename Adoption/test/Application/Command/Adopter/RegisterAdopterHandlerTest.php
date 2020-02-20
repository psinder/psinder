<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Adopter;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopter;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopterHandler;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterRegistered;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryAdoptersFactory;
use Sip\Psinder\SharedKernel\Domain\Gender;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingTest;

final class RegisterAdopterHandlerTest extends TestCase
{
    use EventsInterceptingTest;

    /** @var RegisterAdopterHandler */
    private $handler;

    public function setUp() : void
    {
        $this->handler = new RegisterAdopterHandler(
            InMemoryAdoptersFactory::create($this->eventPublisher()),
            AdopterFactoryFactory::create()
        );
    }

    public function testRegistersValidShelter() : void
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

    protected function context() : TestCase
    {
        return $this;
    }
}
