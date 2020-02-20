<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

interface Event
{
    public function occurredAt(): \DateTimeImmutable;
}
