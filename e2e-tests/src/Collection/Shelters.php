<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection;

interface Shelters
{
    public function create(array $shelter) : string;
}
