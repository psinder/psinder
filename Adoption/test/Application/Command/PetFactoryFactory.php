<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use Sip\Psinder\Adoption\Application\Command\PetFactory;

final class PetFactoryFactory
{
    public static function create() : PetFactory
    {
        return new PetFactory();
    }
}
