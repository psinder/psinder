<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

interface EventPublisher
{
    public function publish(Event ...$events) : void;
}
