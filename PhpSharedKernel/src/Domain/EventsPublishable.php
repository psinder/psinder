<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

interface EventsPublishable
{
    public function publishEvents(EventPublisher $publisher) : void;
}
