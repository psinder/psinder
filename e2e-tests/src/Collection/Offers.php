<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection;

interface Offers
{
    public function post(array $offer) : string;
    public function list() : array;
    public function get(string $id) : ?array;
}
