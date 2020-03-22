<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer\Application;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;

/** @final */
class Application
{
    private ApplicationId $id;
    private AdopterId $adopterId;
    private Offer $offer;

    private function __construct(
        ApplicationId $applicationId,
        Offer $offer,
        AdopterId $adopterId
    ) {
        $this->adopterId = $adopterId;
        $this->offer     = $offer;
        $this->id        = $applicationId;
    }

    public static function prepare(Offer $offer, AdopterId $adopterId) : self
    {
        return new self(new ApplicationId(Uuid::uuid4()->toString()), $offer, $adopterId);
    }

    public function adopterId() : AdopterId
    {
        return $this->adopterId;
    }

    public function offerId() : OfferId
    {
        return $this->offer->id();
    }
}
