<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

use Sip\Psinder\SharedKernel\Domain\Identity\Identity;

interface AggregateRoot extends EventsPublishable
{
    public function id(): Identity;
}
