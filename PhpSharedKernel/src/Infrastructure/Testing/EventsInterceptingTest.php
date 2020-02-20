<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Testing;

use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;
use function Functional\first;
use function get_class;
use function sprintf;

trait EventsInterceptingTest
{
    use TestCaseAwareTrait;
    use EventsPublishingTest;

    /** @var InterceptingEventPublisher|null */
    private $eventPublisher;

    protected function eventPublisher() : InterceptingEventPublisher
    {
        if ($this->eventPublisher === null) {
            $this->eventPublisher = new InterceptingEventPublisher();
        }

        return $this->eventPublisher;
    }
}
