<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Shelter;

final class PostOfferRequest
{
    /** @var string */
    public $shelterId;

    /** @var string[] */
    public $pet;
}
