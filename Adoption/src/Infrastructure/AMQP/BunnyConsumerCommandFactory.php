<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\AMQP;

use Bunny\Client;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\AMQP\BunnyConsumerCommand;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;

final class BunnyConsumerCommandFactory
{
    public function __invoke(ContainerInterface $container) : BunnyConsumerCommand
    {
        return new BunnyConsumerCommand(
            $container->get(Client::class),
            $container->get(LoggerInterface::class),
            $container->get(Serializer::class),
            [
                'adoption.register' => [
                    'service' => RegisterConsumer::class,
                    'dto' => RegisterDTO::class,
                ],
            ],
            $container
        );
    }
}
