<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\AMQP;

use Bunny\Channel;
use Bunny\Client;
use ReflectionObject;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use function sprintf;

final class BunnyEventHandler
{
    private Client $client;
    private Serializer $serializer;
    private string $exchangeName;
    private string $serviceName;
    private CamelCaseToSnakeCaseNameConverter $nameConverter;

    public function __construct(
        Client $client,
        Serializer $serializer,
        string $exchangeName,
        string $serviceName,
        CamelCaseToSnakeCaseNameConverter $nameConverter
    ) {
        $this->client        = $client;
        $this->serializer    = $serializer;
        $this->exchangeName  = $exchangeName;
        $this->serviceName   = $serviceName;
        $this->nameConverter = $nameConverter;
    }

    public function __invoke(Event $event) : void
    {
        if (! $this->client->isConnected()) {
            $this->client->connect();
        }

        $eventName = (new ReflectionObject($event))->getShortName();

        /** @var Channel $channel */
        $channel = $this->client->channel();
        $channel->publish(
            $this->serializer->serialize($event),
            [],
            $this->exchangeName,
            sprintf('%s.%s', $this->serviceName, $this->nameConverter->normalize($eventName))
        );
    }
}
