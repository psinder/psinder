<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command;

use Sip\Psinder\Adoption\Application\Command\Address as AddressDTO;
use Sip\Psinder\SharedKernel\Domain\Address;

final class AddressFactory
{
    public function create(AddressDTO $address) : Address
    {
        return new Address(
            $address->street(),
            $address->number(),
            $address->postalCode(),
            $address->city()
        );
    }
}
