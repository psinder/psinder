<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Offer;

interface OfferRepository
{
    public function findDetails(string $id): ?OfferDetails;

    /** @return OfferApplication[] */
    public function getApplications(string $id): array;
}
