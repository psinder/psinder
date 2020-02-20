<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Application;

use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\Application\Application;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;

final class ApplicationMother
{
    public static function example() : Application
    {
        return Application::prepare(AdopterMother::exampleId());
    }

    public static function withAdopter(AdopterId $adopterId) : Application
    {
        return Application::prepare($adopterId);
    }
}
