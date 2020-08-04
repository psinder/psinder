<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Adopter;

interface Adopters
{
    public function create(Adopter $adopter): void;

    /** @throws AdopterNotFound */
    public function get(AdopterId $adopterId): Adopter;

    /** @throws AdopterNotFound */
    public function update(Adopter $adopter): void;
}
