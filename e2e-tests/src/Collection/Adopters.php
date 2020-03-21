<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection;

interface Adopters
{
    public function register(array $adopter) : string;
}
