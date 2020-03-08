<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Testing;

use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;

trait EventsInterceptingTest
{
    use TestCaseAwareTrait;
    use EventsPublishingTest;

    /** @var EventPublisher|null */
    private $eventPublisher;

    protected function eventPublisher() : InterceptingEventPublisher
    {
        if ($this->eventPublisher === null) {
            $this->eventPublisher = new InterceptingEventPublisher();
        }

        return $this->eventPublisher;
    }
}
