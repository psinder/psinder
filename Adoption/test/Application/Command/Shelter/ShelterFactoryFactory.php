<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Shelter;

use Sip\Psinder\Adoption\Application\Command\AddressFactory;
use Sip\Psinder\Adoption\Application\Command\Shelter\ShelterFactory;

final class ShelterFactoryFactory
{
    public static function create() : ShelterFactory
    {
        return new ShelterFactory(new AddressFactory());
    }
}
