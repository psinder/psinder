<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Adopter;

use Sip\Psinder\Adoption\Application\Command\Adopter\AdopterFactory;

final class AdopterFactoryFactory
{
    public static function create(): AdopterFactory
    {
        return new AdopterFactory();
    }
}
