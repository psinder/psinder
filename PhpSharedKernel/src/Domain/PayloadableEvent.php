<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

interface PayloadableEvent
{
    /** @return mixed[] */
    public function toPayload() : array;
}
