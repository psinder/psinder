<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Shelter;

interface Shelters
{
    public function create(Shelter $shelter) : void;
    /** @throws ShelterNotFound */
    public function update(Shelter $shelter) : void;
    /** @throws ShelterNotFound */
    public function get(ShelterId $id) : Shelter;
    public function exists(ShelterId $id) : bool;
}
