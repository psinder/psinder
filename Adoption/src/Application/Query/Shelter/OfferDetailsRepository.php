<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Shelter;

interface OfferDetailsRepository
{
    public function find(string $id) : ?OfferDetails;
}
