<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer\Application;

use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;

final class Application
{
    private AdopterId $adopterId;

    private function __construct(
        AdopterId $adopterId
    ) {
        $this->adopterId = $adopterId;
    }

    public static function prepare(AdopterId $adopterId) : self
    {
        return new self(
            $adopterId
        );
    }

    public function adopterId() : AdopterId
    {
        return $this->adopterId;
    }
}
