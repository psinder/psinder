<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Offer;

final class OfferApplication
{
    public string $offerId;
    public string $shelterId;
    public string $shelterName;
    public string $adopterId;
    public string $adopterName;

    public function __construct(
        string $offerId,
        string $shelterId,
        string $shelterName,
        string $adopterId,
        string $adopterName
    ) {
        $this->offerId     = $offerId;
        $this->shelterId   = $shelterId;
        $this->shelterName = $shelterName;
        $this->adopterId   = $adopterId;
        $this->adopterName = $adopterName;
    }
}
