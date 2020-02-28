<?php

declare(strict_types = 1);

namespace Sip\Psinder\SharedKernel\Infrastructure\AMQP;

use Bunny\AbstractClient;
use Bunny\Client;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

final class BunnyEventHandler
{
    /** @var Client */
    private $client;

    /** @var Serializer */
    private $serializer;

    /** @var string */
    private $exchangeName;

    /** @var string */
    private $serviceName;

    /** @var CamelCaseToSnakeCaseNameConverter */
    private $nameConverter;

    public function __construct(
        Client $client,
        Serializer $serializer,
        string $exchangeName,
        string $serviceName,
        CamelCaseToSnakeCaseNameConverter $nameConverter
    ) {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->exchangeName = $exchangeName;
        $this->serviceName = $serviceName;
        $this->nameConverter = $nameConverter;
    }

    public function __invoke(Event $event)
    {
        if (!$this->client->isConnected()) {
            $this->client->connect();
        }

        $eventName = (new \ReflectionObject($event))->getShortName();

        $channel = $this->client->channel();
        $channel->publish(
            $this->serializer->serialize($event),
            [],
            $this->exchangeName,
            sprintf('%s.%s', $this->serviceName, $this->nameConverter->normalize($eventName))
        );
    }
}
