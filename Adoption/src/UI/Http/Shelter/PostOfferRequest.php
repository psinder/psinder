<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Shelter;

final class PostOfferRequest
{
    public string $shelterId;

    /** @var string[] */
    public array $pet;
}
