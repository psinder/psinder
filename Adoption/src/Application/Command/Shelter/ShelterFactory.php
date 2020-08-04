<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter;

use Sip\Psinder\Adoption\Application\Command\Address as AddressDTO;
use Sip\Psinder\Adoption\Application\Command\AddressFactory;
use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterName;
use Sip\Psinder\SharedKernel\Domain\Email;

final class ShelterFactory
{
    private AddressFactory $addressFactory;

    public function __construct(AddressFactory $addressFactory)
    {
        $this->addressFactory = $addressFactory;
    }

    public function create(
        string $id,
        string $name,
        AddressDTO $address,
        string $email
    ): Shelter {
        return Shelter::register(
            new ShelterId($id),
            ShelterName::fromString($name),
            $this->addressFactory->create($address),
            Email::fromString($email)
        );
    }
}
