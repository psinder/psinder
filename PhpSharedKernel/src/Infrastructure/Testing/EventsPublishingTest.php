<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Testing;

use SebastianBergmann\Exporter\Exporter;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;
use function array_map;
use function Functional\first;
use function get_class;
use function sprintf;

trait EventsPublishingTest
{
    use TestCaseAwareTrait;

    abstract protected function eventPublisher() : InterceptingEventPublisher;

    protected function assertPublishedEvents(Event ...$expectedEvents) : void
    {
        $expectedEvents = array_map([$this, 'extractEvent'], $expectedEvents);
        $actualEvents   = $this->eventPublisher()->events();
        $actualEvents   = array_map([$this, 'extractEvent'], $actualEvents);

        $this->context()->assertEquals(
            $expectedEvents,
            $actualEvents
        );
    }

    protected function assertPublishedEvent(Event $event) : void
    {
        $result = first(
            $this->eventPublisher()->events(),
            fn(Event $publishedEvent) => $this->extractEvent($event) === $this->extractEvent($publishedEvent)
        );

        $this->context()->assertNotNull(
            $result,
            sprintf('Failed asserting event %s was published', get_class($event))
        );
    }

    /**
     * @return mixed[]
     */
    protected function extractEvent(Event $event) : array
    {
        $event = (new Exporter())->toArray($event);

        unset($event['occurredAt']);

        return $event;
    }
}
