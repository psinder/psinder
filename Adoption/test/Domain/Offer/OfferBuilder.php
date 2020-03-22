<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Offer;

use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;

final class OfferBuilder
{
    public const EXAMPLE_ID = '56ce4d17-f1cd-4b44-adf1-1f11b36781ec';

    private OfferId $id;
    private ShelterId $shelterId;
    private Pet $pet;
    private ?AdopterId $selectedAdopterId = null;

    public function __construct()
    {
        $this->id        = new OfferId(self::EXAMPLE_ID);
        $this->shelterId = ShelterMother::exampleId();
        $this->pet       = PetMother::example();
    }

    public function id(OfferId $id) : self
    {
        $this->id = $id;

        return $this;
    }

    public function selectedAdopter(AdopterId $adopterId) : self
    {
        $this->selectedAdopterId = $adopterId;

        return $this;
    }

    public function shelter(ShelterId $shelterId) : self
    {
        $this->shelterId = $shelterId;

        return $this;
    }

    public function pet(Pet $pet) : self
    {
        $this->pet = $pet;

        return $this;
    }

    public function get() : Offer
    {
        $offer = Offer::post(
            $this->id,
            $this->shelterId,
            $this->pet
        );

        if ($this->selectedAdopterId !== null) {
            $offer->apply($this->selectedAdopterId);
            $offer->selectApplication($this->selectedAdopterId);
        }

        return $offer;
    }
}
