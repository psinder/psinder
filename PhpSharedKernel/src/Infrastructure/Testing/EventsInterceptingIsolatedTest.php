<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Testing;

use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;

trait EventsInterceptingIsolatedTest
{
    use TestCaseAware;
    use EventsPublishingTest;

    private ?EventPublisher $eventPublisher = null;

    protected function eventPublisher(): InterceptingEventPublisher
    {
        if ($this->eventPublisher === null) {
            $this->eventPublisher = new InterceptingEventPublisher();
        }

        return $this->eventPublisher;
    }
}
