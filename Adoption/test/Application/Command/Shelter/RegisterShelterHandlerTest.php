<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Shelter;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Address;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelter;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelterHandler;
use Sip\Psinder\Adoption\Application\Command\UserRegisterer;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterRegistered;
use Sip\Psinder\Adoption\Test\Application\UserRegistererStub;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class RegisterShelterHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private RegisterShelterHandler $handler;

    public function setUp(): void
    {
        $this->overrideServiceAliasWithInstance(UserRegisterer::class, new UserRegistererStub());
        parent::setUp();
        $this->handler = $this->get(RegisterShelterHandler::class);
    }

    public function testRegistersValidShelter(): void
    {
        $id       = Uuid::uuid4()->toString();
        $name     = 'Foo';
        $address  = new Address(
            'foo street',
            '1',
            '00-000',
            'Barville'
        );
        $email    = 'foo@example.com';
        $password = 'foobar';

        $command = new RegisterShelter(
            $id,
            $name,
            $address,
            $email,
            $password
        );

        ($this->handler)($command);

        $this->assertPublishedEvent(new ShelterRegistered(
            $id,
            $name,
            $email,
            [
                'street' => $address->street(),
                'number' => $address->number(),
                'postalCode' => $address->postalCode(),
                'city' => $address->city(),
            ],
            new DateTimeImmutable()
        ));
    }

    protected function context(): TestCase
    {
        return $this;
    }
}
