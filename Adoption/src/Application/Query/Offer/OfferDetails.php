<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Offer;

use Sip\Psinder\Adoption\Application\Query\PetDetails;

final class OfferDetails
{
    private string $id;

    private string $shelterId;

    private PetDetails $pet;

    public function __construct(string $id, string $shelterId, PetDetails $pet)
    {
        $this->id        = $id;
        $this->shelterId = $shelterId;
        $this->pet       = $pet;
    }

    /** @return mixed[] */
    public function toArray() : array
    {
        return [
            'id' => $this->id,
            'shelterId' => $this->shelterId,
            'pet' => $this->pet->toArray(),
        ];
    }
}
