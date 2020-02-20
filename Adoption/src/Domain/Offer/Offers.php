<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;

interface Offers
{
    public function create(Offer $offer) : void;
    /** @throws OfferNotFound */
    public function update(Offer $offer) : void;
    /** @throws OfferNotFound */
    public function get(OfferId $id) : Offer;
    /** @return Offer[] */
    public function forShelter(ShelterId $shelterId) : array;
}
