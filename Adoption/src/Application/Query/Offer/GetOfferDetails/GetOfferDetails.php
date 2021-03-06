<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Offer\GetOfferDetails;

use Sip\Psinder\SharedKernel\Application\Query\Query;

final class GetOfferDetails implements Query
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
