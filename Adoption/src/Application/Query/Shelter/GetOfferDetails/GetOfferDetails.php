<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Shelter\GetOfferDetails;

use Sip\Psinder\SharedKernel\Application\Query\Query;

final class GetOfferDetails implements Query
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id() : string
    {
        return $this->id;
    }
}
