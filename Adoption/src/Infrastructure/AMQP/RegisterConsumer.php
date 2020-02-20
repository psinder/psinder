<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\AMQP;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Address;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopter;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelter;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use function current;

final class RegisterConsumer
{
    /** @var CommandBus */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(RegisterDTO $data) : void
    {
        $role = current($data->roles);

        switch ($role) {
            case 'shelter':
                $this->bus->dispatch(new RegisterShelter(
                    Uuid::uuid4()->toString(),
                    $data->context['name'],
                    new Address(
                        $data->context['street'],
                        $data->context['street_number'],
                        $data->context['postal_code'],
                        $data->context['city']
                    ),
                    $data->email
                ));
                break;

            case 'adopter':
                $this->bus->dispatch(new RegisterAdopter(
                    Uuid::uuid4()->toString(),
                    $data->context['firstName'],
                    $data->context['lastName'],
                    $data->email,
                    $data->context['birthdate'],
                    $data->context['gender']
                ));
                break;
        }
    }
}
