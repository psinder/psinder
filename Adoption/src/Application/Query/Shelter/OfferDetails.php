<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Shelter;

use Sip\Psinder\Adoption\Application\Query\PetDetails;

final class OfferDetails
{
    /** @var string */
    private $id;

    /** @var string */
    private $shelterId;

    /** @var PetDetails */
    private $pet;

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
