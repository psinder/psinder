<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\AMQP;

use Sip\Psinder\Adoption\Application\Command\Address;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelter;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use function current;

final class RegisterConsumer
{
    private CommandBus $bus;

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
                    $data->id,
                    $data->context['name'],
                    new Address(
                        $data->context['address_street'],
                        $data->context['address_number'],
                        $data->context['address_postal'],
                        $data->context['address_city']
                    ),
                    $data->email
                ));
                break;
//            case 'adopter':
//                $this->bus->dispatch(new RegisterAdopter(
//                    Uuid::uuid4()->toString(),
//                    $data->context['firstName'],
//                    $data->context['lastName'],
//                    $data->email,
//                    $data->context['birthdate'],
//                    $data->context['gender']
//                ));
//                break;
        }
    }
}
